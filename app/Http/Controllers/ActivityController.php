<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use App\Activity;
use App\Machine;
use Response;
use Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CreateActivityRequest;

use Illuminate\Http\Request;

class ActivityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$items = Activity::paginate();
		$items->setPath('activity');
		return View::make('admin.activity.view_activity', compact('items'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$activity = new Activity;
		$show = false;
		return View::make('admin.activity.new_edit_activity', compact('activity', 'show'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	 public function store(CreateActivityRequest $request)
 	{
 		$activity = Activity::create($request->all());
		$activity_id = $activity->id;

		//se guardan los datos de la tabla dinamica, (Maquinas)
		$table_details = '';
		if (Input::get('table_details')) {
				$table_details = json_decode(Input::get('table_details'));
				foreach ($table_details->elements as $value) {
						//attach  -> Ingresar los datos relacionados en la tabla pivote
						if($value->machine_id > 0){
							$activity->machines()->attach(['machine_id' => $value->machine_id]);
						}
				}
		}
 		return Redirect::to('admin/activity')->with('success_message', 'Registro guardado!');
 	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$activity = Activity::findOrFail($id);
		$show = true;
		return View::make('admin.activity.new_edit_activity', compact('activity', 'show'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$activity = Activity::findOrFail($id);
		$show = false;
		return View::make('admin.activity.new_edit_activity', compact('activity', 'show'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	 public function update(CreateActivityRequest $request, $id)
 	{
 		$activity = Activity::findOrFail($id);
 		$activity->fill($request->all());
 		$activity->save();

		$table_details = '';
		if (Input::get('table_details')) {
				//se eliminan registros anteriores
				$activity->machines()->detach();
				$table_details = json_decode(Input::get('table_details'));
				foreach ($table_details->elements as $value) {
						//attach  -> Ingresar los datos relacionados en la tabla pivote
						$activity->machines()->attach(['machine_id' => $value->machine_id]);
				}
		}
 		return Redirect::to('admin/activity')->with('success_message', 'Registro actualizado!');
 	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$activity = Activity::findOrFail($id);
		$activity->delete();
		return Redirect::to('admin/activity')->with('success_message', 'El registro ha sido borrado.')->withInput();
	}

	////////////////////////////////////////////////////////////////////////////
	// SECCION DE CODIGO PARA OTROS USOS
	////////////////////////////////////////////////////////////////////////////
	/**
	 * Metodo para hacer la busqueda
	 */
	public static function search(Request $request) {
			$items = array();
			$search = '';
			if ($request->input('search')) {
					$search = $request->input('search');
					$arrparam = explode(' ', $search);
					$items = Activity::whereNested(function($q) use ($arrparam) {
							$p = $arrparam[0];
							$q->whereNested(function($q) use ($p) {
									$q->where('id', 'LIKE', '%' . $p . '%');
									$q->orwhere('name', 'LIKE', '%' . $p . '%');
									$q->orwhere('reference', 'LIKE', '%' . $p . '%');
									$q->orwhere('enable', 'LIKE', '%' . $p . '%');
							});
							$c = count($arrparam);
							if ($c > 1) {
								for ($i = 1; $i < $c; $i++) {
											$p = $arrparam[$i];
											$q->whereNested(function($q) use ($p) {
													$q->where('id', 'LIKE', '%' . $p . '%');
													$q->orwhere('name', 'LIKE', '%' . $p . '%');
													$q->orwhere('reference', 'LIKE', '%' . $p . '%');
													$q->orwhere('enable', 'LIKE', '%' . $p . '%');
											}, 'OR');
									}
							}
					})
					->whereNull('deleted_at')
					->orderBy('name', 'ASC')
					->paginate(10);
					return View::make('admin.activity.view_activity', compact('items', 'search'));
			}
	}
	/**
	 * Metodo para traer las Maquinas relacionados de una Actividad AJAX
	 * [getMachineDataTable description]
	 * @return [type] [description]
	 */
	public function getMachineDataTable() {
			$arrjson = array();
			$activity = null;
			if (\Input::get('activity_id')) {
					$activity_id = \Input::get('activity_id');
					$activity = Activity::find($activity_id);
					$activity->machines;
			}
			$machines = Machine::all();
			$arrjson = array('valid' => true, 'activity' => $activity, 'machines' => $machines);
			return Response::json($arrjson);
	}

}

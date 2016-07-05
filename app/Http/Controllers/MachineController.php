<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use App\Machine;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CreateMachineRequest;


class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $items = Machine::paginate();
      $items->setPath('machine');
      return View::make('admin.machine.view_machine', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $machine = new Machine;
      $show = false;
      return View::make('admin.machine.new_edit_machine', compact('machine', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMachineRequest $request)
    {
      $machine = Machine::create($request->all());
      return Redirect::to('admin/machine')->with('success_message', 'Registro guardado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $machine = Machine::findOrFail($id);
      $show = true;
      return View::make('admin.machine.new_edit_machine', compact('machine', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $machine = Machine::findOrFail($id);
      $show = false;
      return View::make('admin.machine.new_edit_machine', compact('machine', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMachineRequest $request, $id)
    {
      $machine = Machine::findOrFail($id);
      $machine->fill($request->all());
      $machine->save();
      return Redirect::to('admin/machine')->with('success_message', 'Registro actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $machine = Machine::findOrFail($id);
      $machine->delete();
      return Redirect::to('admin/machine')->with('success_message', 'El registro ha sido borrado.')->withInput();
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
            $items = Machine::whereNested(function($q) use ($arrparam) {
                $p = $arrparam[0];
                $q->whereNested(function($q) use ($p) {
                    $q->where('id', 'LIKE', '%' . $p . '%');
                    $q->orwhere('name', 'LIKE', '%' . $p . '%');
                    $q->orwhere('reference', 'LIKE', '%' . $p . '%');
                    $q->orwhere('variables', 'LIKE', '%' . $p . '%');
                    $q->orwhere('use_common', 'LIKE', '%' . $p . '%');
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
                            $q->orwhere('variables', 'LIKE', '%' . $p . '%');
                            $q->orwhere('use_common', 'LIKE', '%' . $p . '%');
                            $q->orwhere('enable', 'LIKE', '%' . $p . '%');
                        }, 'OR');
                    }
                }
            })
            ->whereNull('deleted_at')
            ->orderBy('name', 'ASC')
            ->paginate(10);
            return View::make('admin.machine.view_machine', compact('items', 'search'));
        }
    }
}

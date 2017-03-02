<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Company;
use App\Attachment;
use App\Roles;
use Response;
use View;
use Input;
use Redirect;
use Illuminate\Routing\Route;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\EditCompanyRequest;


class CompanyController extends Controller
{

    /**
    * Funcion para optimizar nuestro código y no repetir lineas
    * [__construct description]
    */
    public function __construct(){
      $this->beforeFilter('@find',['only' => ['edit', 'update', 'destroy']]);
    }

    public function find(Route $route){
      $this->company = Company::find($route->getParameter('company'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //Se agrega metodo search de Scope query
      $items = Company::search($request->search)->orderBy('id', 'DESC')->paginate(15);
      return View::make('admin.company.view_company', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $company = new Company;
      $show = false;
      return View::make('admin.company.new_edit_company', compact('company', 'show'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanyRequest $request)
    {
      $company = Company::create($request->all());
      $company_id = $company->id;

      //Ingresamos la imagen relacionada - Firma Representate legal
        if (\Input::hasFile('file')) {
          $f = \Input::file('file');
          if ($f) {
            $att = new Attachment;
            $att->company_id = $company->id;
            $r = array();
            $r = AttachmentController::uploadAttachment($f, $att);
          }
        }

      //se guardan los datos de la tabla dinamica, (Roles)
      $table_details = '';
      if (Input::get('table_details')) {
          $table_details = json_decode(Input::get('table_details'));
          foreach ($table_details->elements as $value) {
              //attach  -> Ingresar los datos relacionados en la tabla pivote
              $company->roles()->attach([$value->roles_id => ['company_id' =>  $company_id, 'responsability' => $value->responsability]]);
          }
      }
      return Redirect::to('admin/company')->with('success_message', 'Registro guardado!');
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
      $company = Company::where('slug','=', $slug)->first();
      $show = true;
      return View::make('admin.company.new_edit_company', compact('company', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $show = false;
      return view('admin.company.new_edit_company', ['company' => $this->company, 'show' => $show]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(EditCompanyRequest $request, $id)
    {

      $company = company::findOrFail($id);
      $company->fill($request->all());
      $company->save();
       $company_id = $company->id;

      //Ingresamos la imagen seleccionada nuevamente
      if (\Input::hasFile('file')) {
          //Eliminamos la imagen anterior
          AttachmentController::destroyAllBy('company_id', $company->id);
          $f = \Input::file('file');
          if ($f) {
              $att = new Attachment;
              $att->company_id = $company->id;
              $r = array();
              $r = AttachmentController::uploadAttachment($f, $att);
          }
      }

      $table_details = '';
      if (Input::get('table_details')) {
          //se eliminan registros anteriores
          $company->roles()->detach();
          $table_details = json_decode(Input::get('table_details'));
          foreach ($table_details->elements as $value) {
              //attach  -> Ingresar los datos relacionados en la tabla pivote
              $company->roles()->attach([$value->roles_id => ['company_id' =>  $company_id, 'responsability' => $value->responsability]]);
          }
      }

      return Redirect::to('admin/company')->with('success_message', 'Registro actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
      $this->company->delete();
      return Redirect::to('admin/company')->with('success_message', 'El registro ha sido borrado.')->withInput();
    }


    /**
     * Metodo para traer los roles relacionados de una Empresa  - AJAX
     * [getRolesDataTable description]
     * @return [type] [description]
     */
    public function getRolesDataTable() {
        $arrjson = array();
        $company = null;
        if (Input::get('company_id')) {
            $company_id = Input::get('company_id');
            $company = Company::find($company_id);
            $company->roles;
        }
        $roles = Roles::all();
        $arrjson = array('valid' => true, 'company' => $company, 'roles' => $roles);
        return Response::json($arrjson);
    }
}

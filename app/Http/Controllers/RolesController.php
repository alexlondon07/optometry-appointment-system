<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Roles;
use App\Http\Requests\CreateRolesRequest;
use App\Http\Requests\EditRolesRequest;
use View;
use Redirect;
use Illuminate\Routing\Route;

class RolesController extends Controller
{

    /**
    * Funcion para optimizar nuestro código y no repetir lineas
    * [__construct description]
    */
    public function __construct(){
      $this->beforeFilter('@find',['only' => ['edit', 'update', 'destroy']]);
    }

    public function find(Route $route){
      $this->roles = Roles::find($route->getParameter('roles'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //Se agrega metodo search de Scope query
      $items = Roles::search($request->search)->orderBy('id', 'DESC')->paginate(15);
      return View::make('admin.roles.view_roles', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles = new Roles;
      $show = false;
      return View::make('admin.roles.new_edit_roles', compact('roles', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(CreateRolesRequest $request)
    {
      $roles = roles::create($request->all());
      return Redirect::to('admin/roles')->with('success_message', 'Registro guardado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
      $roles = Roles::where('slug','=', $slug)->first();
      $show = true;
      return View::make('admin.roles.new_edit_roles', compact('roles', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $show = false;
      return view('admin.roles.new_edit_roles', ['roles' => $this->roles, 'show' => $show]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRolesRequest $request, $id)
    {
      $this->roles->fill($request->all());
      $this->roles->save();
      return Redirect::to('admin/roles')->with('success_message', 'Registro actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->roles->delete();
      return Redirect::to('admin/roles')->with('success_message', 'El registro ha sido borrado.')->withInput();
    }
}

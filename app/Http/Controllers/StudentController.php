<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Student;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\EditStudentRequest;
use View;
use Redirect;
use Illuminate\Routing\Route;

class StudentController extends Controller
{

    /**
    * Funcion para optimizar nuestro código y no repetir lineas
    * [__construct description]
    */
    public function __construct(){
      $this->beforeFilter('@find',['only' => ['edit', 'update', 'destroy']]);
    }

    public function find(Route $route){
      $this->student = Student::find($route->getParameter('student'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //Se agrega metodo search de Scope query
      $items = Student::search($request->search)->orderBy('id', 'DESC')->paginate(15);
      return View::make('admin.student.view_student', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $student = new Student;
      $show = false;
      return View::make('admin.student.new_edit_student', compact('student', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(CreateStudentRequest $request)
    {
      $student = Student::create($request->all());
      return Redirect::to('admin/student')->with('success_message', 'Registro guardado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
      $student = Student::where('slug','=', $slug)->first();
      $show = true;
      return View::make('admin.student.new_edit_student', compact('student', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $show = false;
      return view('admin.student.new_edit_student', ['student' => $this->student, 'show' => $show]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditStudentRequest $request, $id)
    {
      $this->student->fill($request->all());
      $this->student->save();
      return Redirect::to('admin/student')->with('success_message', 'Registro actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->student->delete();
      return Redirect::to('admin/student')->with('success_message', 'El registro ha sido borrado.')->withInput();
    }
}

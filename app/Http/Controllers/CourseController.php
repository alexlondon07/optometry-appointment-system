<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Course;
use View;
use Redirect;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\EditCourseRequest;
use Illuminate\Routing\Route;

class CourseController extends Controller
{

    /**
    * Funcion para optimizar nuestro código y no repetir lineas
    * [__construct description]
    */
    public function __construct(){
      $this->beforeFilter('@find',['only' => ['edit', 'update', 'destroy']]);
    }

    public function find(Route $route){
      $this->course = Course::find($route->getParameter('course'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //Se agrega metodo search de Scope query
      $items = Course::search($request->search)->orderBy('id', 'DESC')->paginate(15);
      return View::make('admin.course.view_course', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $course = new Course;
      $show = false;
      return View::make('admin.course.new_edit_course', compact('course', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCourseRequest $request)
    {
      $course = Course::create($request->all());
      return Redirect::to('admin/course')->with('success_message', 'Registro guardado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
      $course = Course::where('slug','=', $slug)->first();
      $show = true;
      return View::make('admin.course.new_edit_course', compact('course', 'show'));
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
      return view('admin.course.new_edit_course', ['course' => $this->course, 'show' => $show]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCourseRequest $request, $id)
    {
        $this->course->fill($request->all());
        $this->course->save();
        return Redirect::to('admin/course')->with('success_message', 'Registro actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
      $this->course->delete();
      return Redirect::to('admin/course')->with('success_message', 'El registro ha sido borrado.')->withInput();
    }

}

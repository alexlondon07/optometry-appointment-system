<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('home', 'HomeController@main');

Route::any('auth/logout', 'UserController@doLogout');

// Authentication routes...
Route::get('/', 'Auth\AuthController@getLogin');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

/*
* Rutas para las vistas de administracion de nuestra aplicacion
*/
Route::group(array('prefix' => 'admin', 'middleware' => 'auth'), function() {
  //Home
  Route::resource('main', 'HomeController@main');

  //Usuarios
  Route::resource('user', 'UserController');
  Route::get('user/{slug}', ['as' => 'post', 'uses' => 'UserController@show']);
  Route::get('users/search', 'UserController@search');
/*
  //Cursos
  Route::resource('course', 'CourseController');
  Route::get('course/{slug}', ['as' => 'post', 'uses' => 'CourseController@show']);
  Route::get('courses/search', 'CourseController@search');

  //Estudiantes
  Route::resource('student', 'StudentController');
  Route::get('student/{slug}', ['as' => 'post', 'uses' => 'StudentController@show']);
  Route::get('students/search', 'StudentController@search');*/

  //Empresa
  Route::resource('company', 'CompanyController');
  Route::get('company/{slug}', ['as' => 'post', 'uses' => 'CompanyController@show']);
  Route::get('company/search', 'CompanyController@search');


  //Roles
  Route::resource('roles', 'RolesController');
  Route::get('roles/{slug}', ['as' => 'post', 'uses' => 'RolesController@show']);
  Route::get('roles/search', 'RolesController@search');
});


 // llamados ajax
 Route::group(array('prefix' => 'ajax'), function() {
     Route::any('get_table_roles', 'CompanyController@getRolesDataTable');
 });

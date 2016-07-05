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
	 			Route::resource('main', 'HomeController@main');
				//Usuarios
				Route::resource('user', 'UserController');
        Route::get('users/search', 'UserController@search');
				//Materias Primas
        Route::resource('raw_material', 'RawMaterialController');
        Route::get('raw_materials/search', 'RawMaterialController@search');
				//Actividades
        Route::resource('activity', 'ActivityController');
        Route::get('activitys/search', 'ActivityController@search');
				//Maquinas
        Route::resource('machine', 'MachineController');
        Route::get('machines/search', 'MachineController@search');
				//Productos
        Route::resource('product', 'ProductController');
        Route::get('products/search', 'ProductController@search');
 });

 // llamados ajax
 Route::group(array('prefix' => 'ajax'), function() {
     Route::any('get_machine_data_table', 'ActivityController@getMachineDataTable');
 });

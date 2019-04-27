<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::group(['middleware' => ['auth']], function () { 
//     Route::get('/admin', function () {
// 	    return view('admin.role');
// 	});
	Route::group(['prefix' => 'admin','middleware' => ['auth'],'namespace' => 'Admin','as' => 'admin.'], function () { 
		Route::get('/dashboard', 'HomeController@index')->name('dashboard');
		Route::resource('role', 'RoleController');
	    Route::get('/roles/getData', 'RoleController@getData')->name('role.getData');
	});
//});

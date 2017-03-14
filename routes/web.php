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

//Route::get('service/{id}/auth', 'ServiceController@service');
//
//Route::get('service/connect/{drive}', 'ServiceController@connect');
//
//Route::post('upload', 'UploadController@index');
//
//Route::get('files/{id}/{conversion?}/{arguments?}', 'FileController@show')->name('files.show');

Route::group(['middleware' => 'auth'], function () {

    Route::get('home', 'HomeController@index');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

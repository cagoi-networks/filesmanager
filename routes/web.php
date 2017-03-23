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

Route::get('home', 'HomeController@index');
Route::get('myfiles', 'HomeController@files');

Route::group(['middleware' => 'auth'], function () {

    Route::get('profle', 'ProfileController@index')->name('profile.index');
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

Route::get('service/{id}/auth', 'ServiceController@service');

Route::get('service/connect/{drive}', 'ServiceController@connect');

Route::post('upload', 'UploadController@index');

Route::get('files/{file_id}/{pattern?}', 'FileController@show')->where(['pattern' => '-\/[a-z0-9=,&\/]+'])->name('files.show');

Route::post('import/process', 'ImportController@process')->name('import.process');

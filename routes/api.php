<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('import/process', 'ImportController@process')->name('import.process');

Route::get('import/status/{api_token}', 'ImportController@status')->name('import.status');

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {

    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});




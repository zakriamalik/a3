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

# main app routes
Route::get('/', 'MortCalcController@index');
Route::get('/process', 'MortCalcController@process');
Route::get('/readme', 'MortCalcController@readme');

# conditional log viewer route based on app environment
if(config('app.env')=='local'){
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

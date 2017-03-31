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

#new app route
Route::get('/', 'MortCalcController@index');
Route::get('/process', 'MortCalcController@process');

#new routes
Route::get('/search', 'ProverbController@search');

#Original Routes
#Route::get('/', function () {
#    return view('welcome');
#});

if(config('app.env')=='local'){
    #Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

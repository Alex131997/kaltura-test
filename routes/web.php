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

Route::group(['prefix' => 'media'], function () {
    Route::get('/', 'MediaController@index');
    Route::get('/count', 'MediaController@count');
    Route::get('/list', 'MediaController@list');
    Route::delete('/{id}', 'MediaController@delete');
});

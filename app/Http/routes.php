<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['api','throttle:2']], function () {
    Route::resource('task','TaskController');
    Route::resource('tag','TagController');

//API
    Route::get('task','TaskController@index');
    Route::get('task/{id}','TaskController@show');
    Route::post('task','TaskController@store');
    Route::put('task/{id}','TaskController@update');
    Route::delete('task/{id}','TaskController@destroy');

    Route::get('tag','TagController@index');
    Route::get('tag/{id}','TagController@show');
    Route::post('tag','TagController@store');
    Route::put('tag/{id}','TagController@update');
    Route::delete('tag/{id}','TagController@destroy');
});



Route::get('auth/login', function () {
    echo "Acces denied";
});
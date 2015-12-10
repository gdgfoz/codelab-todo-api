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

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('teste', function(){
    $user = \GDGFoz\User::first();
    event( new \GDGFoz\Events\UserCreateEvent($user));
});

Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'middleware' => ['auth','csrf']], function($route){

    $route->get('/', ['as' => 'dash.home', 'uses' => 'DashboardController@index']);
    $route->post('/generate-token', ['as' => 'dash.generateToken', 'uses' => 'DashboardController@generateToken']);

});

Route::get('/', function () {
    return view('welcome');
});

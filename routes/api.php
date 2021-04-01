<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'api'], function () {
	Route::get('/user', 'UserController@getUser');

	Route::get('/athenticated', 'UserController@athenticated');
});

Route::post('/login', 'AuthController@login');

Route::post('/register', 'AuthController@register');

Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
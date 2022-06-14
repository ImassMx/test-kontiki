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

Route::group(['namespace'  => 'Auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::group(['namespace'  => 'Api\v1\Sales'], function () {
    Route::get('sale', 'SalesController@getSale')->middleware('auth:api');;
    Route::post('sale', 'SalesController@store')->middleware('auth:api');;
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

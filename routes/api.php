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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::get('food', 'Api\FoodController@index');
Route::get('food/{id}', 'Api\FoodController@show');
Route::post('food', 'Api\FoodController@store');
Route::put('food/{id}', 'Api\FoodController@update');
Route::delete('food/{id}', 'Api\FoodController@destroy');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
Route::Group(['namespace'=>'Api'],function (){
    Route::post('register', 'UserController@register' );
    Route::post('login', 'UserController@login' );
});


Route::Group(['namespace'=>'Api', 'middleware' => 'auth:api'], function () {
    Route::post('upload_post', 'UserController@uploadPost' );
    Route::post('get_posts', 'UserController@getPosts' );
    Route::post('get_pros', 'UserController@getPros' );
    Route::post('send_connect', 'UserController@sendConnect' );
    Route::post('get_pendings', 'UserController@getPendings' );
    Route::post('upload_recipe', 'UserController@uploadRecipe' );
});

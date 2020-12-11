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
    Route::post('get_recipes', 'UserController@getRecipes' );
    Route::post('get_user_info', 'UserController@getUserInfo' );
    Route::post('remove_pending', 'UserController@removePending' );
    Route::post('update_token', 'UserController@updateToken' );
    Route::post('get_badge', 'UserController@getBadge');
    Route::post('get_connections', 'UserController@getConnections');
    Route::post('apply_pending', 'UserController@applyPending');
    Route::post('view_recipe', 'UserController@viewRecipe');
    Route::post('get_profile', 'UserController@getProfile');
    Route::post('update_profile', 'UserController@updateProfile');
    Route::post('send_report', 'UserController@sendReport');
});

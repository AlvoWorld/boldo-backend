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
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login' );
    Route::get('get_tyles_styles', 'UserController@getTypsAndStyles'); 
});

Route::Group(['namespace'=>'Api', 'prefix'=>'admin'], function () {
    Route::post('register', 'AdminController@register' );
    Route::post('login', 'AdminController@login' );
});

Route::Group(['namespace'=>'Api', 'middleware' => 'auth:api', 'prefix'=>'admin'], function () {
    Route::get('get_data', 'AdminController@getData' );
    Route::post('get_types', 'AdminController@getTypes' );
    Route::post('save_type', 'AdminController@saveType' );
    Route::post('delete_type', 'AdminController@deleteType' );
    Route::post('get_styles', 'AdminController@getStyles' );
    Route::post('save_style', 'AdminController@saveStyle' );
    Route::post('delete_style', 'AdminController@deleteStyle' );
    Route::post('get_users', 'AdminController@getUsers' );
    Route::post('delete_user', 'AdminController@deleteUser');
    Route::post('active_user', 'AdminController@activeUser');
    Route::get('get_posts', 'AdminController@getPosts');
    Route::post('remove_post', 'AdminController@removePost');
    Route::post('active_post', 'AdminController@activePost');
    Route::get('get_recipes', 'AdminController@getRecipes');
    Route::post('remove_recipe', 'AdminController@removeRecipe');
    Route::post('active_recipe', 'AdminController@activeRecipe');
});

Route::Group(['namespace'=>'Api', 'middleware' => 'auth:api'], function () {
    Route::post('update_token', 'UserController@updateToken');
    Route::post('get_user_posts', 'UserController@getUserPosts');
    Route::post('sign_out', 'UserController@signOut' );
    Route::post('update_profile', 'UserController@updateProfile');
    Route::get('get_posts', 'UserController@getPosts');
    Route::post('upload_post', 'UserController@uploadPost' );
    Route::post('delete_post', 'UserController@deletePost' );
    Route::post('send_report', 'UserController@sendReport');
    Route::get('get_recipes', 'UserController@getRecipes' );
    Route::post('upload_recipe', 'UserController@uploadRecipe' );
    Route::post('view_recipe', 'UserController@viewRecipe');
    Route::post('get_contacts', 'UserController@getContacts');
    Route::get('get_pros', 'UserController@getPros' );
    Route::post('make_chatroom', 'UserController@makeChatRoom');
    Route::post('set_block', 'UserController@setBlock');
    Route::post('get_blocks', 'UserController@getBlocks');
    Route::post('remove_block', 'UserController@removeBlock');




    Route::post('send_connect', 'UserController@sendConnect' );
    Route::post('get_pendings', 'UserController@getPendings' );
    Route::post('remove_pending', 'UserController@removePending' );
    Route::post('get_badge', 'UserController@getBadge');
    Route::post('get_connections', 'UserController@getConnections');
    Route::post('apply_pending', 'UserController@applyPending');
    Route::post('get_profile', 'UserController@getProfile');
    Route::post('send_message', 'UserController@sendMessage');
});

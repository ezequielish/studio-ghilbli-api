<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('login', 'LoginController@index')->middleware('auth.basic');

Route::post('user', 'UserController@index');
Route::put('user', 'UserController@update')->middleware(['auth:sanctum']);
Route::delete('user', 'UserController@user_delete')->middleware(['auth:sanctum']);


//COMMENTS
Route::post('comment', 'CommentsController@add')->middleware(['auth:sanctum', 'ability:comment_create']);
Route::get('comment/{id_film}', 'CommentsController@get');//->middleware(['auth:sanctum', 'ability:comment_view'])
Route::put('comment/{id_comment}', 'CommentsController@update')->middleware(['auth:sanctum', 'ability:comment_update']);
Route::delete('comment/{id_comment}', 'CommentsController@comment_delete')->middleware(['auth:sanctum', 'ability:comment_delete']);

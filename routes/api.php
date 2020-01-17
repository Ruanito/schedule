<?php

use Illuminate\Http\Request;

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

Route::post('contact', 'Api\ContactController@store');
Route::put('contact/{id}', 'Api\ContactController@update');
Route::delete('contact/{id}', 'Api\ContactController@destroy');

Route::get('contact/{contact_id}/message', 'Api\MessageController@index');
Route::post('contact/{contact_id}/message', 'Api\MessageController@store');
Route::put('contact/{contact_id}/message/{id}', 'Api\MessageController@update');
Route::delete('contact/{contact_id}/message/{id}', 'Api\MessageController@destroy');

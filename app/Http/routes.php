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
Route::get('/', 'PagesController@index');
Route::get('/update-password', 'PagesController@showUpdatePasswordForm');
Route::put('/update-password', 'PagesController@updatePassword');

Route::resource('clients', 'ClientController');

Route::auth();
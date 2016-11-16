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
Route::singularResourceParameters();


// Home and Update Password Routes
Route::get('/', 'PagesController@index');
Route::get('/update-password', 'PagesController@showUpdatePasswordForm');
Route::put('/update-password', 'PagesController@updatePassword');

// Clients Routes
Route::resource('/clients', 'ClientsController');

// Invoice Routes
Route::resource('/clients.invoices', 'InvoicesController');


// Authentication Routes
Route::auth();
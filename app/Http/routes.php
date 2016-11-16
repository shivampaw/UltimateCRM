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

// Home and Update Password Routes
Route::get('/', 'PagesController@index');
Route::get('/update-password', 'PagesController@showUpdatePasswordForm');
Route::put('/update-password', 'PagesController@updatePassword');

// Clients RESTFUL Routes
Route::resource('/clients', 'ClientsController');

// Invoice Routes
Route::get('/clients/{client}/invoices', 'InvoicesController@index');
Route::get('/invoices/{invoice}', 'InvoicesController@show');
Route::get('/clients/{client}/create-invoice', 'InvoicesController@create');
Route::post('/clients/{client}/create-invoice', 'InvoicesController@store');
Route::get('/invoices/{invoice}/edit', 'InvoicesController@edit');
Route::put('/invoices/{invoice}/edit', 'InvoicesController@update');

// Authentication Routes
Route::auth();
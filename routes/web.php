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

// Authentication Routes
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/signed-login/{user}', 'Auth\\LoginController@loginSignedUrl')->name('signedLogin')->middleware('signed');
Auth::routes();

// Super Admin Routes
Route::resource('/admins', 'SuperAdmin\\AdminsController', ['except' => ['show']]);

// Admin Routes
Route::resource('/clients', 'Admin\\ClientsController');
Route::resource('/clients.invoices', 'Admin\\InvoicesController', ['except' => ['update', 'edit']]);
Route::resource('/clients.projects', 'Admin\\ProjectsController', ['except' => ['update', 'edit']]);

// Admin + Client Routes
Route::get('/', 'PagesController@index');
Route::get('/update-password', 'PagesController@showUpdatePasswordForm');
Route::put('/update-password', 'PagesController@updatePassword');
Route::resource('/projects.chats', 'Shared\\ChatController', ['only' => ['store']]);

// Client Routes
Route::get('/invoices', 'ClientsOnlyController@allInvoices');
Route::get('/invoices/{id}', 'ClientsOnlyController@showInvoice');
Route::get('/invoices/{id}/pay', 'ClientsOnlyController@payInvoice');
Route::post('/invoices/{id}', 'ClientsOnlyController@paidInvoice');
Route::get('/projects', 'ClientsOnlyController@allProjects');
Route::get('/projects/{id}', 'ClientsOnlyController@showProject');
Route::get('/projects/{id}/accept', 'ClientsOnlyController@acceptProject');

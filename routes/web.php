<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/testSMS/{id}', 'SMSController@sendSMS')->name('sms');

//Routes for creating and updating a client
Route::get('/clients', 'ClientsController@index')
    ->name('clients.index')->middleware('permission:show_clients');
Route::get('/clients/create', 'ClientsController@create')
    ->name('clients.create')->middleware('permission:create_clients');
Route::post('/clients', 'ClientsController@store')
    ->name('clients.store')->middleware('permission:create_clients');
Route::get('/clients/{client}', 'ClientsController@show')
    ->name('clients.show')->middleware('permission:show_clients');
Route::patch('/clients/{client}', 'ClientsController@update')
    ->name('clients.update')->middleware('permission:edit_clients');
//Routes for management of contacts
Route::get('/clients-contacts/{id}', 'ContactsController@create')
    ->name('contacts.create')->middleware('permission:create_clients');
Route::patch('/clients-contacts/{client}', 'ContactsController@store')
    ->name('contacts.store')->middleware('permission:create_clients');
Route::patch('/clients-contacts-update/{client}', 'ContactsController@update')
    ->name('contacts.update')->middleware('permission:edit_contacts');
//Routes for creating or updating addresses
Route::get('/clients-address/{id}', 'AddressesController@create')
    ->name('address.create')->middleware('permission:create_clients');
Route::post('/clients-address', 'AddressesController@store')
    ->name('address.store')->middleware('permission:create_clients');
Route::patch('/clients-address', 'AddressesController@update')
    ->name('address.update')->middleware('permission:edit_addresses');
// Route for attaching a measurer
Route::post('/clients/attach-measurer', 'ClientsController@attach')
    ->name('clients.attach')->middleware('permission:edit_clients');
Route::get('/clients/{client}/detach-measurer', 'ClientsController@detach')
    ->name('clients.detach')->middleware('permission:edit_clients');
// Route for change the status on a client
Route::get('/clients/{client}/suspend', 'ClientsController@status')
    ->name('clients.status')->middleware('permission:change_status');
// Route for sending test email
Route::get('/clients/{client}/test-email', 'ClientsController@testEmail')->name('clients.testEmail');

Route::get('/measurers', 'MeasurersController@index')
    ->name('measurers.index')->middleware('permission:show_measurers');
Route::get('/measurers/create', 'MeasurersController@create')
    ->name('measurers.create')->middleware('permission:create_measurers');
Route::post('/measurers', 'MeasurersController@store')
    ->name('measurers.store')->middleware('permission:create_measurers');
Route::delete('/measurers', 'MeasurersController@destroy')
    ->name('measurers.destroy')->middleware('permission:delete_measurers');

// Routes for documents
Route::get('/documents', 'DocumentsController@index')->name('documents.index');
Route::get('/documents/create', 'DocumentsController@create')
    ->name('documents.create')->middleware('permission:create_documents');
Route::post('/documents', 'DocumentsController@store')
    ->name('documents.store')->middleware('permission:create_documents');
Route::get('/documents/{document}/ver', 'DocumentsController@show')
    ->name('documents.show')->middleware('permission:show_documents');
Route::get('/documents/{id}/authorize', 'DocumentsController@authorize_docto')
    ->name('documents.authorize')->middleware('permission:authorize_documents');
Route::get('/documents/{id}/cancel', 'DocumentsController@cancel')
    ->name('documents.cancel')->middleware('permission:cancel_documents');
Route::get('/documents/{id}/print', 'DocumentsController@print')->name('documents.print');

Route::get('/payments', 'PaymentsController@index')
    ->name('payments.index')->middleware('permission:pay_documents');
Route::post('/payments', 'PaymentsController@store')
    ->name('payments.store')->middleware('permission:pay_documents');

Route::get('/users', 'UsersController@index')
    ->name('users.index')->middleware('permission:show_users');
Route::get('/users/create', 'UsersController@create')
    ->name('users.create')->middleware('permission:create_users');
Route::post('/users', 'UsersController@store')
    ->name('users.store')->middleware('permission:create_users');
Route::get('/users/{user}/edit', 'UsersController@edit')
    ->name('users.edit')->middleware('permission:edit_users');
Route::patch('/users/{user}', 'UsersController@update')
    ->name('users.patch')->middleware('permission:edit_users');
Route::delete('/users/{user}', 'UsersController@destroy')
    ->name('users.destroy')->middleware('permission:delete_users');
Route::post('/users/{user}/permissions', 'UsersController@permissions')
    ->name('users.permissions')->middleware('permission:edit_users');

Route::post('/price', 'PricesController@store')
    ->name('prices.store')->middleware('permission:update_prices');

Route::get('/projects', 'ProjectsController@index')
    ->name('projects.index')->middleware('permission:show_projects');
Route::post('/projects', 'ProjectsController@store')
    ->name('projects.store')->middleware('permission:create_projects');

Route::get('/tanks', 'TanksController@index')
    ->name('tanks.index')->middleware('permission:show_tanks');
Route::get('/tanks/create', 'TanksController@create')
    ->name('tanks.create')->middleware('permission:create_tanks');
Route::post('/tanks', 'TanksController@store')
    ->name('tanks.store')->middleware('permission:create_tanks');

Route::get('/inventories', 'InventoriesController@index')
    ->name('inventories.index')->middleware('permission:show_inventories');
Route::get('/inventories/create', 'InventoriesController@create')
    ->name('inventories.create')->middleware('permission:create_inventories');
Route::post('/inventories', 'InventoriesController@store')
    ->name('inventories.store')->middleware('permission:create_inventories');
Route::post('inventories/fill-tank', 'InventoriesController@fillTanks')->name('inventories.fillTanks');

Route::get('/clients/{client}/link', 'ClientsController@link_client')
    ->name('clients.link');

Route::get('/test-print', function (){
    return view('print.guarantee');
});

Route::get('/deposits', 'DepositsController@index')->name('deposits.index');
Route::get('/deposits/create', 'DepositsController@create')->name('deposits.create');
Route::post('/deposits', 'DepositsController@store')->name('deposits.store');
Route::get('/deposits/{deposit}/show', 'DepositsController@show')->name('deposits.show');

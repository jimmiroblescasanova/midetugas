<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TanksController;
use App\Http\Controllers\FactorsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DocumentsController;

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

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
Route::get('/clients-address/{client}', 'AddressesController@create')
    ->name('address.create')->middleware('permission:create_clients');
Route::patch('/clients-address/{client}', 'AddressesController@update')
    ->name('address.update')->middleware('permission:edit_addresses');
// Route for attaching a measurer
Route::post('/clients/attach-measurer', 'ClientsController@attach')
    ->name('clients.attach')->middleware('permission:edit_clients');
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
Route::get('measurers/{measurer}/edit', 'MeasurersController@edit')
    ->name('measurers.edit');
Route::patch('measurers/{measurer}', 'MeasurersController@update')
    ->name('measurers.update');
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
Route::get('/documents/{id}/authorize', 'DocumentsController@authorizeDocument')
    ->name('documents.authorize')->middleware('permission:authorize_documents');
Route::get('/documents/{document}/cancel', [DocumentsController::class, 'cancel'])->name('documents.cancel')->middleware('permission:cancel_documents');
Route::get('/documents/{id}/print', 'DocumentsController@print')->name('documents.print');

Route::get('documents/multiple-pdf/download', 'DocumentsController@multiPdf')->name('documents.multiPdf');

Route::get('/payments', 'PaymentsController@index')->name('payments.index')->middleware('permission:pay_documents');
Route::post('/payments/create', 'PaymentsController@createForm')->name('payments.createForm');
// Livewire component
Route::get('/payments/create/client/{id}', Livewire\CreatePayment::class)->name('payments.create');
Route::post('/payments', 'PaymentsController@store')->name('payments.store')->middleware('permission:pay_documents');
Route::get('/payments/show/{payment}', 'PaymentsController@show')->name('payments.show');
Route::delete('/payments/show/{payment}', 'PaymentsController@destroy')->name('payments.delete');

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

Route::get('/projects', 'ProjectsController@index')->name('projects.index')->middleware('permission:show_projects');
Route::post('/projects', 'ProjectsController@store')->name('projects.store')->middleware('permission:create_projects');
Route::get('/projects/{project}/edit', 'ProjectsController@edit')->name('projects.edit');
Route::patch('/projects/{project}/edit', 'ProjectsController@update')->name('projects.update');
Route::delete('/projects/{project}/edit', [ProjectsController::class, 'destroy'])->name('projects.destroy');

Route::get('/tanks', 'TanksController@index')
    ->name('tanks.index')->middleware('permission:show_tanks');
Route::get('/tanks/create', 'TanksController@create')
    ->name('tanks.create')->middleware('permission:create_tanks');
Route::post('/tanks', 'TanksController@store')
    ->name('tanks.store')->middleware('permission:create_tanks');
Route::get('/tanks/{tank}/edit', 'TanksController@edit')->name('tanks.edit');
Route::patch('/tank/{tank}/edit', 'TanksController@update')->name('tanks.update');
Route::delete('/tanks/{tank}/edit', [TanksController::class, 'destroy'])->name('tanks.destroy');

Route::get('/inventories', 'InventoriesController@index')
    ->name('inventories.index')->middleware('permission:show_inventories');
Route::get('/inventories/create', 'InventoriesController@create')
    ->name('inventories.create')->middleware('permission:create_inventories');
Route::post('/inventories', 'InventoriesController@store')
    ->name('inventories.store')->middleware('permission:create_inventories');
Route::post('inventories/fill-tank', 'InventoriesController@fillTanks')
    ->name('inventories.fillTanks');

Route::get('/clients/{client}/link', 'ClientsController@link_client')->name('clients.link');

Route::get('/deposits', 'DepositsController@index')->name('deposits.index');
Route::get('/deposits/create', 'DepositsController@create')->name('deposits.create');
Route::post('/deposits', 'DepositsController@store')->name('deposits.store');
Route::get('/deposits/{deposit}/show', 'DepositsController@show')->name('deposits.show');
Route::get('/deposits/{deposit}/cancel', 'DepositsController@cancel')->name('deposits.cancel');

Route::get('/reportes/TomaDeLectura', 'ReportsController@parametrosTomaDeLectura')->name('tomaDeLectura.parameters');
Route::post('reportes/TomaDeLectura', 'ReportsController@pdfTomaDeLectura')->name('tomaDeLectura.show');

Route::get('/reportes/cobranza', 'ReportsController@parametrosCobranza')->name('cobranza.parameters');
Route::post('/reportes/cobranza/excel', 'ReportsController@excelCobranza')->name('cobranza.excel');
Route::post('/reportes/cobranza/screen', 'ReportsController@pantalaCobranza')->name('cobranza.screen');
Route::post('/reports/cobranza/pdf', 'ReportsController@pdfCobranza')->name('cobranza.pdf');

Route::get('/reports/edc', 'ReportsController@edcParameters')->name('edc.parameters');
Route::post('/ajax/edc', 'ReportsController@edcScreen')->name('edc.screen');
Route::post('/reports/edc/excel', 'ReportsController@edcExportExcel')->name('edc.excel');

Route::get('/configurations/tasks', 'ConfigurationsController@tasks')
    ->name('configuration.tasks')
    ->middleware('permission:run_tasks');
Route::post('/configurations/tasks', 'ConfigurationsController@recalcularInventario')
    ->name('configurations.run.recalcularInventario')
    ->middleware('permission:run_tasks');
Route::get('procesos/descarga-masiva', 'ConfigurationsController@descargaMasiva')->name('procesos.descargaMasiva');
Route::post('procesos/descarga-masiva', 'ConfigurationsController@multiPdf')->name('procesos.multiPdf');

Route::get('/configuration/factors', 'FactorsController@index')->name('factors.index');
Route::post('/configuration/factors', 'FactorsController@store')->name('factors.store');
Route::delete('/configuration/factors', [FactorsController::class, 'destroy'])->name('factors.destroy');

Route::get('/download/{file}', function ($file) {
    return Storage::download('pdf/' . $file . '.zip');
});

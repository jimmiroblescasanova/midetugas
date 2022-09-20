<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TanksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\FactorsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\MeasurersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\ConfigurationsController;

Auth::routes();
Route::get('/', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/testSMS/{id}', [SMSController::class, 'sendSMS'])->name('sms');

//Routes for creating and updating a client
Route::get('/clients', App\Http\Livewire\Clients::class)->name('clients.index')->middleware('permission:show_clients');
Route::get('/clients/create', [ClientsController::class, 'create'])->name('clients.create')->middleware('permission:create_clients');
Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store')->middleware('permission:create_clients');
Route::get('/clients/{client}', [ClientsController::class, 'show'])->name('clients.show')->middleware('permission:show_clients');
Route::patch('/clients/{client}', [ClientsController::class, 'update'])->name('clients.update')->middleware('permission:edit_clients');

//Routes for management of contacts
Route::get('/clients-contacts/{id}', [ContactsController::class, 'create'])->name('contacts.create')->middleware('permission:create_clients');
Route::patch('/clients-contacts/{client}', [ContactsController::class, 'store'])->name('contacts.store')->middleware('permission:create_clients');
Route::patch('/clients-contacts-update/{client}', [ContactsController::class, 'update'])->name('contacts.update')->middleware('permission:edit_contacts');

//Routes for creating or updating addresses
Route::get('/clients-address/{client}', [AddressesController::class, 'create'])->name('address.create')->middleware('permission:create_clients');
Route::patch('/clients-address/{client}', [AddressesController::class, 'update'])->name('address.update')->middleware('permission:edit_addresses');

// Route for change the status on a client
Route::get('/clients/{client}/suspend', [ClientsController::class, 'status'])->name('clients.status')->middleware('permission:change_status');

// Route for sending test email
Route::get('/clients/{client}/test-email', [ClientsController::class, 'testEmail'])->name('clients.testEmail');

// Ruta para CRUD de los medidores
Route::get('/measurers', App\Http\Livewire\Measurers::class)->name('measurers.index')->middleware('permission:show_measurers');
Route::get('/measurers/create', [MeasurersController::class, 'create'])->name('measurers.create')->middleware('permission:create_measurers');
Route::post('/measurers', [MeasurersController::class, 'store'])->name('measurers.store')->middleware('permission:create_measurers');
Route::get('measurers/{measurer}/edit', [MeasurersController::class, 'edit'])->name('measurers.edit');
Route::patch('measurers/{measurer}', [MeasurersController::class, 'update'])->name('measurers.update');
Route::delete('/measurers/{measurer}', [MeasurersController::class, 'destroy'])->name('measurers.destroy')->middleware('permission:delete_measurers');

// Routes for documents
Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
Route::get('/documents/create', [DocumentsController::class, 'create'])->name('documents.create')->middleware('permission:create_documents');
Route::post('/documents', [DocumentsController::class, 'store'])->name('documents.store')->middleware('permission:create_documents');
Route::get('/documents/{document}/ver', [DocumentsController::class, 'show'])->name('documents.show')->middleware('permission:show_documents');
Route::get('/documents/{id}/authorize', [DocumentsController::class, 'authorizeDocument'])->name('documents.authorize')->middleware('permission:authorize_documents');
Route::get('/documents/{document}/cancel', [DocumentsController::class, 'cancel'])->name('documents.cancel')->middleware('permission:cancel_documents');
Route::get('/documents/{id}/print', [DocumentsController::class, 'print'])->name('documents.print');
Route::get('/documents/multiple-pdf/download', [DocumentsController::class, 'multiPdf'])->name('documents.multiPdf');

Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index')->middleware('permission:pay_documents');
Route::post('/payments/create', [PaymentsController::class, 'createForm'])->name('payments.createForm');
Route::post('/payments', [PaymentsController::class, 'store'])->name('payments.store')->middleware('permission:pay_documents');
Route::get('/payments/show/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
Route::delete('/payments/show/{payment}', [PaymentsController::class, 'destroy'])->name('payments.delete');
// Livewire component
Route::get('/payments/create/client/{id}', \App\Http\Livewire\CreatePayment::class)->name('payments.create');

Route::get('/users', [UsersController::class, 'index'])->name('users.index')->middleware('permission:show_users');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create')->middleware('permission:create_users');
Route::post('/users', [UsersController::class, 'store'])->name('users.store')->middleware('permission:create_users');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit')->middleware('permission:edit_users');
Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.patch')->middleware('permission:edit_users');
Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete_users');
Route::post('/users/{user}/permissions', [UsersController::class, 'permissions'])->name('users.permissions')->middleware('permission:edit_users');

Route::post('/price', [PricesController::class, 'store'])->name('prices.store')->middleware('permission:update_prices');

Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index')->middleware('permission:show_projects');
Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store')->middleware('permission:create_projects');
Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
Route::patch('/projects/{project}/edit', [ProjectsController::class, 'update'])->name('projects.update');
Route::delete('/projects/{project}/edit', [ProjectsController::class, 'destroy'])->name('projects.destroy');

Route::get('/tanks', [TanksController::class, 'index'])->name('tanks.index')->middleware('permission:show_tanks');
Route::get('/tanks/create', [TanksController::class, 'create'])->name('tanks.create')->middleware('permission:create_tanks');
Route::post('/tanks', [TanksController::class, 'store'])->name('tanks.store')->middleware('permission:create_tanks');
Route::get('/tanks/{tank}/edit', [TanksController::class, 'edit'])->name('tanks.edit');
Route::patch('/tanks/{tank}/edit', [TanksController::class, 'update'])->name('tanks.update');
Route::delete('/tanks/{tank}/edit', [TanksController::class, 'destroy'])->name('tanks.destroy');

Route::get('/inventories', [InventoriesController::class, 'index'])->name('inventories.index')->middleware('permission:show_inventories');
Route::get('/inventories/create', [InventoriesController::class, 'create'])->name('inventories.create')->middleware('permission:create_inventories');
Route::post('/inventories', [InventoriesController::class, 'store'])->name('inventories.store')->middleware('permission:create_inventories');

Route::get('/deposits', [DepositsController::class, 'index'])->name('deposits.index');
Route::get('/deposits/create', [DepositsController::class, 'create'])->name('deposits.create');
Route::post('/deposits', [DepositsController::class, 'store'])->name('deposits.store');
Route::get('/deposits/{deposit}/show', [DepositsController::class, 'show'])->name('deposits.show');
Route::get('/deposits/{deposit}/cancel', [DepositsController::class, 'cancel'])->name('deposits.cancel');

Route::get('/reportes/TomaDeLectura', [ReportsController::class, 'parametrosTomaDeLectura'])->name('tomaDeLectura.parameters');
Route::post('reportes/TomaDeLectura', [ReportsController::class, 'pdfTomaDeLectura'])->name('tomaDeLectura.show');

Route::get('/reportes/cobranza', [ReportsController::class, 'parametrosCobranza'])->name('cobranza.parameters');
Route::post('/reportes/cobranza/excel', [ReportsController::class, 'excelCobranza'])->name('cobranza.excel');
Route::post('/reportes/cobranza/screen', [ReportsController::class, 'pantallaCobranza'])->name('cobranza.screen');
Route::post('/reports/cobranza/pdf', [ReportsController::class, 'pdfCobranza'])->name('cobranza.pdf');

Route::get('/reports/edc', [ReportsController::class, 'edcParameters'])->name('edc.parameters');
Route::post('/ajax/edc', [ReportsController::class, 'edcScreen'])->name('edc.screen');
Route::post('/reports/edc/excel', [ReportsController::class, 'edcExportExcel'])->name('edc.excel');

Route::get('/configurations/tasks', [ConfigurationsController::class, 'tasks'])->name('configuration.tasks')->middleware('permission:run_tasks');
Route::post('/configurations/tasks', [ConfigurationsController::class, 'recalcularInventario'])->name('configurations.run.recalcularInventario')->middleware('permission:run_tasks');
Route::get('procesos/descarga-masiva', [ConfigurationsController::class, 'descargaMasiva'])->name('procesos.descargaMasiva');
Route::post('procesos/descarga-masiva', [ConfigurationsController::class, 'multiPdf'])->name('procesos.multiPdf');

Route::get('/configuration/factors', [FactorsController::class, 'index'])->name('factors.index');
Route::post('/configuration/factors', [FactorsController::class, 'store'])->name('factors.store');
Route::delete('/configuration/factors', [FactorsController::class, 'destroy'])->name('factors.destroy');

Route::get('/download/{file}', function ($file) {
    return Storage::download('pdf/' . $file . '.zip');
});

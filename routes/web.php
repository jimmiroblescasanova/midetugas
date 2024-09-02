<?php

use Illuminate\Support\Facades\Bus;
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
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\MeasurersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/testSMS/{id}', [SMSController::class, 'sendSMS'])->name('sms');

//Routes for creating and updating a client
Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index')->middleware('permission:show_clients');
Route::get('/clients/create', [ClientsController::class, 'create'])->name('clients.create')->middleware('permission:create_clients');
Route::get('/clients/export', [ClientsController::class, 'export'])->name('clients.export')->middleware('permission:show_clients');
Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store')->middleware('permission:create_clients');
Route::get('/clients/{client}', [ClientsController::class, 'show'])->name('clients.show')->middleware('permission:show_clients');
Route::patch('/clients/{client}', [ClientsController::class, 'update'])->name('clients.update')->middleware('permission:edit_clients');

// Route for change the status on a client
Route::get('/clients/{client}/suspend', [ClientsController::class, 'status'])->name('clients.status')->middleware('permission:change_status');

// Route for sending test email
Route::get('/clients/{client}/test-email', [ClientsController::class, 'testEmail'])->name('clients.testEmail');

// Ruta para CRUD de los medidores
Route::get('/measurers', [MeasurersController::class, 'index'])->name('measurers.index')->middleware('permission:show_measurers');
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
Route::post('/documents/{document}/ver/discount', [DocumentsController::class, 'discount'])->name('documents.discount')->middleware('permission:create_documents');
Route::get('/documents/{id}/authorize', [DocumentsController::class, 'authorizeDocument'])->name('documents.authorize')->middleware('permission:authorize_documents');
Route::get('/documents/{document}/cancel', [DocumentsController::class, 'cancel'])->name('documents.cancel')->middleware('permission:cancel_documents');
Route::get('/documents/{document}/send-email', [DocumentsController::class, 'sendEmail'])->name('documents.sendEmail');
Route::get('/documents/{id}/print', [DocumentsController::class, 'print'])->name('documents.print');
Route::get('/documents/multiple-pdf/download', [DocumentsController::class, 'multiPdf'])->name('documents.multiPdf');

Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index')->middleware('permission:pay_documents');
Route::post('/payments', [PaymentsController::class, 'store'])->name('payments.store')->middleware('permission:pay_documents');
Route::get('/payments/{payment}/show', [PaymentsController::class, 'show'])->name('payments.show');
Route::get('/payments/{payment}/edit', [PaymentsController::class, 'edit'])->name('payments.edit');
Route::delete('/payments/{payment}/show', [PaymentsController::class, 'destroy'])->name('payments.delete');

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
Route::post('/inventories/create', [InventoriesController::class, 'store'])->name('inventories.store')->middleware('permission:create_inventories');
Route::get('/inventories/{inventory}/show', [InventoriesController::class, 'show'])->name('inventories.show');
Route::delete('/inventories/{inventory}/show', [InventoriesController::class, 'destroy'])->name('inventories.destroy');

Route::get('/deposits', [DepositsController::class, 'index'])->name('deposits.index');
Route::get('/deposits/create', [DepositsController::class, 'create'])->name('deposits.create');
Route::post('/deposits', [DepositsController::class, 'store'])->name('deposits.store');
Route::get('/deposits/{deposit}/show', [DepositsController::class, 'show'])->name('deposits.show');
Route::get('/deposits/{deposit}/cancel', [DepositsController::class, 'cancel'])->name('deposits.cancel');

Route::group([
    'prefix' => '/reportes/TomaDeLectura',
    'as' => 'reportes.tomaDeLectura.',
], function() {
    Route::get('/', [ReportsController::class, 'parametrosTomaDeLectura'])->name('parameters');
    Route::post('/', [ReportsController::class, 'pdfTomaDeLectura'])->name('show');
});

Route::group([
    'prefix' => '/reportes/cobranza',
    'as' => 'reportes.cobranza.',
], function() {
    Route::get('/', [ReportsController::class, 'parametrosCobranza'])->name('parameters');
    Route::post('/excel', [ReportsController::class, 'excelCobranza'])->name('excel');
    Route::post('/screen', [ReportsController::class, 'pantallaCobranza'])->name('screen');
    Route::post('/pdf', [ReportsController::class, 'pdfCobranza'])->name('pdf');
});

Route::group([
    'prefix' => '/reportes/edc',
    'as' => 'reportes.edc.'
], function() {
    Route::get('/', [ReportsController::class, 'edcParameters'])->name('parameters');
    Route::post('/ajax', [ReportsController::class, 'edcScreen'])->name('screen');
    Route::post('/excel', [ReportsController::class, 'edcExportExcel'])->name('excel');
});

Route::get('/configurations/tasks', [ConfigurationsController::class, 'tasks'])->name('configuration.tasks')->middleware('permission:run_tasks');
Route::post('/configurations/tasks/1', [ConfigurationsController::class, 'recalcularInventario'])->name('configurations.run.recalcularInventario')->middleware('permission:run_tasks');
Route::post('/configurations/tasks/2', [ConfigurationsController::class, 'recalculateClient'])->name('configurations.run.recalculate-client');

Route::get('procesos/descarga-masiva', [ConfigurationsController::class, 'descargaMasiva'])->name('procesos.descargaMasiva');
Route::post('procesos/descarga-masiva', [ConfigurationsController::class, 'multiPdf'])->name('procesos.multiPdf');

Route::get('/configuration/factors', [FactorsController::class, 'index'])->name('factors.index');
Route::post('/configuration/factors', [FactorsController::class, 'store'])->name('factors.store');
Route::get('/configuration/factors/{factor}/edit', [FactorsController::class, 'edit'])->name('factors.edit');
Route::patch('/configuration/factors/{factor}/edit', [FactorsController::class, 'update'])->name('factors.update');
Route::delete('configuration/factors/{factor}/edit', [FactorsController::class, 'destroy'])->name('factors.destroy');

Route::get('/download/{file}', function ($file) {
    return Storage::download('pdf/' . $file . '.zip');
});

Route::get('/reportes/depositos-garantia', \App\Http\Livewire\Reportes\DepositosGarantia::class)->name('reportes.depositos-garantia.index')->middleware('auth');

Route::get('/batch/{batchId}', function (string $batchId) {
    return Bus::findBatch($batchId);
});
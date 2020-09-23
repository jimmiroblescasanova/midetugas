<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/testSMS/{id}', 'SMSController@sendSMS')->name('sms');

//Routes for creating and updating a client
Route::get('/clients', 'ClientsController@index')->name('clients.index');
Route::get('/clients/create', 'ClientsController@create')->name('clients.create');
Route::post('/clients', 'ClientsController@store')->name('clients.store');
Route::get('/clients/{client}', 'Clientscontroller@show')->name('clients.show');
Route::patch('/clients/{client}', 'ClientsController@update')->name('clients.update');
//Routes for management of contacts
Route::get('/clients-contacts/{id}', 'ContactsController@create')->name('contacts.create');
Route::patch('/clients-contacts/{client}', 'ContactsController@store')->name('contacts.store');
Route::patch('/clients-contacts-update/{client}', 'ContactsController@update')->name('contacts.update');
//Routes for creating or updating addresses
Route::get('/clients-address/{id}', 'AddressesController@create')->name('address.create');
Route::post('/clients-address', 'AddressesController@store')->name('address.store');
Route::patch('/clients-address', 'AddressesController@update')->name('address.update');
// Route for attaching a measurer
Route::post('/clients/attach-measurer', 'ClientsController@attach')->name('clients.attach');

Route::get('/measurers', 'MeasurersController@index')->name('measurers.index');
Route::get('/measurers/create', 'MeasurersController@create')->name('measurers.create');
Route::post('/measurers', 'MeasurersController@store')->name('measurers.store');
Route::delete('/measurers', 'MeasurersController@destroy')->name('measurers.destroy');



<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/testSMS/{id}', 'SMSController@sendSMS')->name('sms');

Route::get('/clients', 'ClientsController@index')->name('clients.index');
Route::get('/clients/create', 'ClientsController@create')->name('clients.create');
Route::post('/clients', 'ClientsController@store')->name('clients.store');
Route::get('/clients/{client}', 'Clientscontroller@show')->name('clients.show');

Route::get('/clients/{id}/contacts', 'ClientsController@contacts')->name('clients.contacts.add');
Route::post('/clients/contacts', 'ClientsController@saveContact')->name('clients.contacts.store');
Route::get('/clients-address/{id}', 'ClientsController@address')->name('clients.address.add');
Route::post('/clients-address', 'ClientsController@saveAddress')->name('clients.address.store');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sendSMS/{phone_number}', 'SMSController@sendSMS');

Route::get('/clients', 'ClientsController@index')->name('clients.index');
Route::get('clients/create', 'ClientsController@create')->name('clients.create');
Route::post('/clients', 'ClientsController@store')->name('clients.store');

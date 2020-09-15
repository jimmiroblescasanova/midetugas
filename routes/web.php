<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.index');
})->name('index');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

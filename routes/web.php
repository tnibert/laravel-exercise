<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    error_log('Some message here.');
    return view('welcome');
});

Route::get('/newcompany', function () {
    return view('newcompany');
});

Route::get('/newemployee', function () {
    return view('newemployee');
});

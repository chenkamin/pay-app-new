<?php

use Illuminate\Support\Facades\Route;
use Iiluminate\app\Http\Controllers\Controller;
use Iiluminate\app\Http\Middleware\Cors;

Route::resource('payments', Controller::class);
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

Route::post('/payment', 'App\Http\Controllers\Controller@createPayment');
Route::get('/payments', 'App\Http\Controllers\Controller@getPayments');
Route::put('/payment/{id}', 'App\Http\Controllers\Controller@updatePayment');
Route::delete('/payment/{id}', 'App\Http\Controllers\Controller@removePayment');


// how to handle cors in laravel app?




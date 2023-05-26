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

Route::get('/', 'HomeController@index');
Route::get('/refresh', 'HomeController@refresh');
Route::get('/bahan/{mode}', 'HomeController@getBahan');
Route::get('/satuan/{id}', 'HomeController@getSatuan');
Route::resource('home', HomeController::class);

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

Route::get('/', 'RegistrationController@index')->name('registration');
Route::post('/', 'RegistrationController@store')->name('registration.store');

Route::get('/v/{secret}', 'VisitController@index')->name('visit.index');

Route::get('/admin/scan/entry/{event}', 'ScanController@entry')->name('scan.entry');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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

Route::get('/admin/scan/{event}', 'ScanController@index')->name('scan.index');
Route::post('/admin/scan/{event}', 'ScanController@code')->name('scan.scan');

Route::get('/admin/list/{event}', 'ListController@index')->name('list.index');
Route::get('/admin/select', 'AdminController@select')->name('admin.select');

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

Auth::routes();

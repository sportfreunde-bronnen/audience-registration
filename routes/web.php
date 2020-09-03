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

Route::get('/admin/scan/{event}', 'Admin\ScanController@index')->name('scan.index');
Route::post('/admin/scan/{event}', 'Admin\ScanController@code')->name('scan.scan');

Route::get('/admin/list/{event}', 'Admin\ListController@index')->name('list.index');
Route::get('/admin/select', 'Admin\AdminController@select')->name('admin.select');

Route::get('/admin/event/create', 'Admin\EventController@create')->name('event.create');
Route::post('/admin/event/store', 'Admin\EventController@store')->name('event.store.new');
Route::post('/admin/event/store/{event}', 'Admin\EventController@store')->name('event.store');
Route::get('/admin/event/edit/{event}', 'Admin\EventController@edit')->name('event.edit');
Route::get('/admin/event/delete/{event}', 'Admin\EventController@delete')->name('event.delete');

Route::get('/admin', 'Admin\AdminController@index')->name('admin');
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

Auth::routes();

<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Social Routes
 */
Route::get('login/{service}','Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback','Auth\LoginController@handleProviderCallback');

/**
 * PDF Route
 */

Route::name('imprimir')->get('/imprimir-pdf','Controller@imprimir');
Route::get('driver-pdf','PdfController\DowloadPdfController@driverPdfDowload');
Route::get('owner-pdf','PdfController\DowloadPdfController@ownerPdfDowload');

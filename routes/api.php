<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * API Routes
 */

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');

/**
 * Api Resource Routes
 */

Route::resource('get-roles','ResourceController\RolesController');
Route::resource('owners','ResourceController\OwnersController');
Route::resource('city','ResourceController\CitiesController');
Route::resource('drivers','ResourceController\DriversController');
Route::resource('tipe-vehicles','ResourceController\TipeVehiclesController');
Route::resource('vehicle','ResourceController\VehiclesController');
Route::resource('department','ResourceController\DepartmentsController');
Route::resource('route','ResourceController\RoutesController');

/**
 * Api Custom Routes
 */
Route::get('get-city-paginate','CustomController\CitiesController@index');
Route::get('get-driver-paginate','CustomController\DriversController@index');
Route::get('get-owner-paginate','CustomController\OwnersController@index');
Route::get('get-vehicle-paginate','CustomController\VehiclesController@index');
Route::get('get-route-paginate','CustomController\RoutesController@index');

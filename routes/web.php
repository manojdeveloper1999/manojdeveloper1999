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

Route::get('/error', function () {
  return view('error');
});


Route::group(['prefix' => 'auth'], function () {
  Route::get('install', 'MainController@install');

  Route::get('load', 'MainController@load');

  Route::get('uninstall', function () {
    echo 'uninstall';
    return app()->version();
  });

  Route::get('remove-user', function () {
    echo 'remove-user';
    return app()->version();
  });
});

Route::any('/bc-api/{endpoint}', 'MainController@proxyBigCommerceAPIRequest')
  ->where('endpoint', 'v2\/.*|v3\/.*');

  Route::get('/', 'OrderController@importExport');
// Route::get('importExport', 'OrderController@importExport');
Route::get('downloadExcel/{type}', 'OrderController@downloadExcel');
Route::get('generate/product-url', 'OrderController@generateProductURL');
Route::post('importExcel', 'OrderController@importExcel');


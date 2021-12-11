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
Route::get('/', [
  'uses' => 'DashboardController@home',
  'as' => 'home'
]);

Route::get('/login', [
    'uses' => 'AuthController@login',
    'as' => 'login'
]);
Route::post('/login/process', [
  'uses' => 'AuthController@loginProcess',
  'as' => 'loginProcess'
]);
Route::get('/logout', [
  'uses' => 'AuthController@logout',
  'as' => 'logout'
]);


Route::group(['middleware' => ['auth']], function () {
  Route::get('/home', [
    'uses' => 'DashboardController@index',
    'as' => 'dashboard'
  ]);

  Route::post('/home/add/barang/process', [
    'uses' => 'BarangController@add',
    'as' => 'add_barang'
  ]);

  Route::put('/home/edit/barang/process', [
    'uses' => 'BarangController@edit',
    'as' => 'edit_barang'
  ]);

  Route::get('/home/delete/barang/{id_gform_custom}', [
    'uses' => 'BarangController@delete',
    'as' => 'delete_barang'
  ]);
});
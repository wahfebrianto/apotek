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

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::resource('pegawai', 'MPegawaiController');
Route::get('pegawai/delete/{id}', 'MPegawaiController@delete');
Route::get('pegawai/edit/{id}', 'MPegawaiController@edit');
Route::post('pegawai/change', 'MPegawaiController@change')->name('pegawai.change');

Route::resource('pamakologi','MPamakologiController');

Route::resource('pbf','MPBFController');

Route::resource('pengeluaran', 'MPengeluaranController');
Route::get('pengeluaran/delete/{id}', 'MPengeluaranController@delete');
Route::get('pengeluaran/edit/{id}', 'MPengeluaranController@edit');
Route::post('pengeluaran/change', 'MPengeluaranController@change')->name('pengeluaran.change');

Auth::routes();

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

Route::resource('pamakologi','MPamakologiController');

Route::resource('pbf','MPBFController');

Route::resource('obat','MObatController');

//stok
Route::get('stok/{id_obat}','MStokController@index');
Route::get('stok/{id_obat}/create','MStokController@create')->name('stok.create');
Route::get('stok/{id_stok}/edit','MStokController@edit')->name('stok.edit');
Route::post('stok','MStokController@store')->name('stok.store');
Route::put('stok/{id_stok}','MStokController@update')->name('stok.update');
Route::delete('stok/{id_stok}','MStokController@destroy')->name('stok.destroy');

Route::resource('pengeluaran', 'MPengeluaranController');

Route::resource('log', 'MLogController');

//pembelian
Route::get('pembelian','MPembelianController@index')->name('pembelian.index');
Route::get('pembelian/create','MPembelianController@create')->name('pembelian.create');
Route::get('pembelian/list/{no_nota}','MPembelianController@listpembelian')->name('pembelian.listpembelian');
Route::post('pembelian/rowdata', 'MPembelianController@rowdata')->name('pembelian.rowdata');
Route::post('pembelian','MPembelianController@store')->name('pembelian.store');
Route::delete('pembelian/{no_nota}','MPembelianController@destroy')->name('pembelian.destroy');

//penerimaan
Route::get('penerimaan','MPembelianController@penerimaan')->name('penerimaan.index');
Route::post('penerimaan', 'MPembelianController@terima')->name('pembelian.terima');

//pembayaran
Route::get('pembayaran','MPembelianController@pembayaran')->name('pembayaran.index');
Route::post('pembayaran', 'MPembelianController@bayar')->name('pembelian.bayar');

//penjualan
Route::get('penjualan','MPenjualanController@index')->name('penjualan.index');
Route::get('penjualan/create','MPenjualanController@create')->name('penjualan.create');
Route::get('penjualan/list/{no_nota}','MPenjualanController@listpenjualan')->name('penjualan.listpenjualan');
Route::get('penjualan/copyresep/{no_nota}','MPenjualanController@copy_resep')->name('penjualan.copy_resep');
Route::post('penjualan/rowdata', 'MPenjualanController@rowdata')->name('penjualan.rowdata');
Route::post('penjualan','MPenjualanController@store')->name('penjualan.store');
Route::delete('penjualan/{no_nota}','MPenjualanController@destroy')->name('penjualan.destroy');

//laporan
Route::get('laporan','LaporanController@index')->name('laporan.index');
Route::get('laporan/generate', 'LaporanController@generate')->name('laporan.generate');

//grafik
Route::get('laporan/grafik','LaporanController@grafik')->name('grafik.index');


Auth::routes();

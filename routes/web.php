<?php

use App\Models\Nasabah;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('user', 'UserController');
    Route::resource('tipe-nasabah', 'TipeNasabahController');
    Route::post('nasabah/update-status/{id}', 'NasabahController@updateStatus');
    Route::resource('nasabah', 'NasabahController');
    Route::resource('pengajuan-data-nasabah', 'PengajuanDataNasabah');
    Route::get('pinjaman/update-status/{id}', 'PinjamanController@updateStatus');
    Route::get('pinjaman/cekNotif', 'PinjamanController@cekNotif');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('pelunasan', 'PelunasanController');
    Route::get('data-tambahan-nasabah/update-status/{id}', 'DataTambahanNasabahController@updateStatus');
    Route::resource('data-tambahan-nasabah', 'DataTambahanNasabahController');
    
    Route::get('syarat-pinjaman-umroh/update-status/{id}', 'SyaratPinjamanUmrohController@updateStatus');
    Route::resource('syarat-pinjaman-umroh', 'SyaratPinjamanUmrohController');

    Route::get('laporan/', 'LaporanController@index');
    Route::get('laporan/chart', 'ChartLaporanController@index');
});

require __DIR__.'/auth.php';
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
    Route::get('nasabah/hasil-skoring/{id}', 'NasabahController@hasilSkoring');
    Route::resource('nasabah', 'NasabahController');
    Route::resource('pengajuan-data-nasabah', 'PengajuanDataNasabah');
    Route::get('pinjaman/update-status/{id}/{status}', 'PinjamanController@updateStatus')->name('update-status-pinjaman');
    Route::get('pinjaman/cekNotif', 'PinjamanController@cekNotif');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('pelunasan', 'PelunasanController');
    Route::get('data-tambahan-nasabah/update-status/{id}', 'DataTambahanNasabahController@updateStatus');
    Route::resource('data-tambahan-nasabah', 'DataTambahanNasabahController');
    
    Route::get('syarat-pinjaman-umroh/update-status/{id}', 'SyaratPinjamanUmrohController@updateStatus');
    Route::resource('syarat-pinjaman-umroh', 'SyaratPinjamanUmrohController');

    Route::get('laporan/', 'LaporanController@index');
    Route::get('laporan/chart', 'ChartLaporanControlle@index');

    Route::prefix('master-scoring')->group(function () {
        Route::resource('kategori-kriteria', 'KategoriKriteriaController');
        Route::resource('kriteria', 'KriteriaController');
        Route::resource('option', 'OptionController');
    });
});

require __DIR__.'/auth.php';
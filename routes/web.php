<?php

use App\Models\Nasabah;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard/cekNotif', 'DashboardController@cekNotif');
    Route::get('dashboard/cekDetailNotif', 'DashboardController@cekDetailNotif');
    Route::resource('user', 'UserController');
    Route::resource('kantor-cabang', 'KantorCabangController');
    Route::resource('tipe-nasabah', 'TipeNasabahController');
    Route::post('nasabah/update-status/{id}', 'NasabahController@updateStatus');
    Route::get('nasabah/hasil-skoring/{id}', 'NasabahController@hasilSkoring');
    Route::resource('nasabah', 'NasabahController');
    Route::resource('pengajuan-data-nasabah', 'PengajuanDataNasabah');
    Route::get('pinjaman/update-status/{id}/{status}', 'PinjamanController@updateStatus')->name('update-status-pinjaman');
    Route::get('pinjaman/cekNotif', 'PinjamanController@cekNotif');
    Route::get('pinjaman/pencairan', 'PinjamanController@pencairanPinjaman');
    Route::get('pinjaman/sudah-pencairan', 'PinjamanController@pencairanSudah');
    Route::get('pinjaman/proses-pencairan/{id}', 'PinjamanController@prosesPencairan');
    Route::get('pinjaman/update-pencairan/{id}/{status}', 'PinjamanController@updateStatusPencairan');
    Route::get('pinjaman/monitoring', 'PinjamanController@monitoringPinjaman');
    Route::get('pinjaman/monitoring-detail/{id}', 'PinjamanController@detailMonitoringPinjaman')->name('pinjaman.monitoring-detail');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('asuransi-pinjaman', 'AsuransiPinjamanController');
    Route::get('pelunasan/late-payment', 'PelunasanController@latePayment');
    Route::get('pembayaran-pinjaman/list-pembayaran', 'PelunasanController@pembayaranPinjaman')->name('pembayaran-pinjaman');
    Route::get('pembayaran-pinjaman/list-pembayaran/{id}/detail', 'PelunasanController@detailPembayaranPinjaman');
    Route::get('pembayaran-pinjaman/bayar/{kode_pelunasan}', 'PelunasanController@bayarPinjaman');
    Route::resource('pelunasan', 'PelunasanController');
    Route::get('data-tambahan-peminjam/update-status/{id}', 'DataTambahanNasabahController@updateStatus')->name('update-status-pinmo');
    Route::resource('data-tambahan-peminjam', 'DataTambahanNasabahController');
    
    Route::get('syarat-pinjaman-umroh/update-status/{id}', 'SyaratPinjamanUmrohController@updateStatus');
    Route::resource('syarat-pinjaman-umroh', 'SyaratPinjamanUmrohController');

    Route::get('laporan/', 'LaporanController@index');
    Route::get('laporan/excel', 'LaporanController@export')->name('export-excel');
    Route::get('laporan/chart', 'ChartLaporanController@index');

    Route::prefix('master-scoring')->group(function () {
        Route::resource('kategori-kriteria', 'KategoriKriteriaController');
        Route::resource('kriteria', 'KriteriaController');
        Route::resource('option', 'OptionController');
    });
});

require __DIR__.'/auth.php';
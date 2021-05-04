<?php

use App\Models\Nasabah;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', function(){
        return view('dashboard');
    })->name('dashboard');
    Route::resource('user', 'UserController');
    Route::resource('tipe-nasabah', 'TipeNasabahController');
    Route::post('nasabah/update-status/{id}', 'NasabahController@updateStatus');
    Route::resource('nasabah', 'NasabahController');
    Route::get('pinjaman/update-status/{id}', 'PinjamanController@updateStatus');
    Route::get('pinjaman/cekNotif', 'PinjamanController@cekNotif');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('pelunasan', 'PelunasanController');
});

require __DIR__.'/auth.php';

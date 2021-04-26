<?php

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
    Route::get('nasabah/update-status/{id}', 'NasabahController@updateStatus');
    Route::resource('nasabah', 'NasabahController');
    Route::get('pinjaman/update-status/{id}', 'PinjamanController@updateStatus');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('pelunasan', 'PelunasanController');
});

require __DIR__.'/auth.php';

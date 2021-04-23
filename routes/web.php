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
    Route::get('nasabah/update-status/{id}', 'NasabahController@updateStatus');
    Route::resource('nasabah', 'NasabahController');
    Route::resource('pinjaman', 'PinjamanController');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('nasabah', 'API\NasabahController@index');
    // data tambahan nasabah
    Route::post('data-tambahan-nasabah', 'API\NasabahController@inputDataTambahan');
    Route::get('me', 'API\ApiAuthController@me');
    Route::get('logout', 'API\ApiAuthController@logout');
    // melengkapi data profil
    Route::post('lengkapi-data', 'API\ApiAuthController@lengkapiData');
    // jenis pinjaman
    Route::get('jenis-pinjaman', 'API\JenisPinjamanController@index');

    // pengajuan pinjaman
    Route::post('pinjaman', 'API\PinjamanController@store');
    // detail pinjaman
    Route::get('pinjaman/{id}', 'API\PinjamanController@show');
    // get pinjaman by nasabah
    Route::get('pinjaman-per-nasabah', 'API\PinjamanController@getPinjamanByNasabah');

    // bank
    Route::get('bank', 'API\PinjamanController@getBank');

    Route::post('pembayaran', 'API\ApiPembayaran@store');

    Route::get('status-cicilan/{id_pinjaman}/{cicilan_ke}', 'API\ApiPembayaran@getStatusCicilan');
    // get saldo per nasabah
    Route::get('get-saldo-hutang-nasabah', 'API\NasabahController@getSaldoAndHutangPerNasabah');
    
});
// // pengajuan pinjaman
// Route::post('pinjaman', 'API\PinjamanController@store');
// register
Route::post('register', 'API\ApiAuthController@register');
// login
Route::post('login', 'API\ApiAuthController@login');

// Route::post('register-user', 'API\ApiController@registerUser');
Route::post('send-verification', 'API\ApiController@sendVerificationCode');
Route::get('check-verification', 'API\ApiController@checkVerificationCode');
Route::post('resend-verification', 'API\ApiController@resendVerificationCode');


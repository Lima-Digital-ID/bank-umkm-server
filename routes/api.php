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
    // get data nasabah by id
    Route::get('get-nasabah', 'API\NasabahController@getNasabahById');

    // scoring
    Route::get('kategori-kriteria', 'API\ScoringController@getKategoriKriteria');
    Route::post('prosess-skoring', 'API\ScoringController@processScoring');
    Route::get('get-option-by-kriteria/{id}', 'API\ScoringController@getOptionByKriteria');
    // end scoring

    // data tambahan nasabah (syarat pinjaman diatas 5jt)
    Route::post('data-tambahan-nasabah', 'API\NasabahController@inputDataTambahan');
    // syarat pinjaman umroh
    Route::post('syarat-pinjaman-umroh', 'API\NasabahController@inputSyaratPinjamanUmroh');
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

    Route::get('get-cicilan/{id_pinjaman}', 'API\ApiPembayaran@getCicilan');
    // get saldo per nasabah
    Route::get('get-saldo-hutang-nasabah', 'API\NasabahController@getSaldoAndHutangPerNasabah');

    // get notification per nasabah
    Route::get('get-notification', 'API\NotificationController@getNotifPerNasabah');
    Route::get('get-notification-not-seen', 'API\NotificationController@getNotifPerNasabahNotSeen');
    Route::get('detail-notification/{id}', 'API\NotificationController@getDetailNotif');
    Route::get('read-notification/{id}', 'API\NotificationController@isRead');
    Route::post('update-sended', 'API\NotificationController@updateSended');
    // end notification
    
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


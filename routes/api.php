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
    Route::post('update-profile-nasabah', 'API\NasabahController@updateProfile');
    Route::post('update-photo-nasabah', 'API\NasabahController@updatePhoto');
    Route::post('delete-photo-nasabah', 'API\NasabahController@deletePhoto');
    Route::post('update-password', 'API\NasabahController@updatePassword');

    // scoring
    Route::get('kategori-kriteria', 'API\ScoringController@getKategoriKriteria');
    Route::post('prosess-skoring', 'API\ScoringController@processScoring');
    Route::get('get-option-by-kriteria/{id}', 'API\ScoringController@getOptionByKriteria');
    Route::get('get-scoring-per-nasabah', 'API\ScoringController@getScoringPerNasahabah');
    // end scoring

    // data tambahan nasabah (syarat pinjaman diatas 5jt)
    Route::post('data-tambahan-nasabah', 'API\NasabahController@inputDataTambahan');
    // syarat pinjaman umroh
    Route::post('syarat-pinjaman-umroh', 'API\NasabahController@inputSyaratPinjamanUmroh');
    Route::get('me', 'API\ApiAuthController@me');
    Route::get('logout', 'API\ApiAuthController@logout');
    // melengkapi data profil
    Route::post('lengkapi-data', 'API\ApiAuthController@lengkapiData');
    
    Route::get('get-verif-data', 'API\NasabahController@getVerifData');
    // jenis pinjaman
    Route::get('jenis-pinjaman', 'API\JenisPinjamanController@index');

    // pengajuan pinjaman
    Route::post('pinjaman', 'API\PinjamanController@store');
    // detail pinjaman
    Route::get('pinjaman/{id}', 'API\PinjamanController@show');
    // get pinjaman by nasabah
    Route::get('pinjaman-per-nasabah', 'API\PinjamanController@getPinjamanByNasabah');
    Route::get('pinjaman-pending', 'API\PinjamanController@getPinjamanPendingByNasabah');

    // bank
    Route::get('bank', 'API\PinjamanController@getBank');

    // Pembayaran
    Route::prefix('pembayaran')->group(function() {
        Route::post('/', 'API\ApiPembayaran@store');
    });
    // END Pembayaran

    Route::get('get-cicilan/{id_pinjaman}', 'API\ApiPembayaran@getCicilan');
    // get saldo per nasabah
    Route::get('get-saldo-hutang-nasabah', 'API\NasabahController@getSaldoAndHutangPerNasabah');
    Route::get('get-limit-nasabah', 'API\NasabahController@getLimit');

    // get notification per nasabah
    Route::get('get-notification', 'API\NotificationController@getNotifPerNasabah');
    Route::get('get-new-notification', 'API\NotificationController@getNewNotifPerNasabah');
    Route::get('get-notification-not-seen', 'API\NotificationController@getNotifPerNasabahNotSeen');
    Route::get('detail-notification/{id}', 'API\NotificationController@getDetailNotif');
    Route::get('read-notification/{id}', 'API\NotificationController@isRead');
    Route::post('update-notification-sended', 'API\NotificationController@updateSended');
    // end notification

    // alamat
    Route::get('get-provinsi', 'API\AlamatController@getProvinsi');
    Route::get('get-kabupaten/{id_provinsi}', 'API\AlamatController@getKabupaten');
    Route::get('get-kecamatan/{id_kecamatan}', 'API\AlamatController@getKecamatan');
    // end alamat
    
    Route::get('kantor-cabang', 'API\PinjamanController@getCabang');
    
});
// // pengajuan pinjaman
// Route::post('pinjaman', 'API\PinjamanController@store');
// register
Route::post('register', 'API\ApiAuthController@register');
// login
Route::post('login', 'API\ApiAuthController@login');
// midtrans callback
Route::post('midtrans', 'API\MidtransController@callback');
// Route::post('register-user', 'API\ApiController@registerUser');
Route::post('send-verification', 'API\ApiController@sendVerificationCode');
Route::get('check-verification', 'API\ApiController@checkVerificationCode');
// Route::post('resend-verification', 'API\ApiController@resendVerificationCode'); // sms
Route::post('resend-verification', 'API\ApiController@resendEmail');
Route::get('verify-email/{key}', 'API\ApiAuthController@verifyEmail');

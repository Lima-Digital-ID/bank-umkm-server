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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// register
Route::post('register', 'API\ApiAuthController@register');
// jenis pinjaman
Route::get('jenis-pinjaman', 'API\JenisPinjamanController@index');
// pengajuan pinjaman
Route::post('pinjaman', 'API\PinjamanController@store');
Route::get('pinjaman/{id}', 'API\PinjamanController@show');
// get pinjaman by nasabah
Route::get('pinjaman-per-nasabah', 'API\PinjamanController@getPinjamanByNasabah');
// Route::post('register-user', 'API\ApiController@registerUser');
Route::post('send-verification', 'API\ApiController@sendVerificationCode');
Route::get('check-verification', 'API\ApiController@checkVerificationCode');
Route::post('resend-verification', 'API\ApiController@resendVerificationCode');

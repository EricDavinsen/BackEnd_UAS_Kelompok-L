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

Route::get('email/verify/{id}', 'Api\EmailVerifController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\EmailVerifController@resend')->name('verificationapi.resend');

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => 'auth:api'], function(){
    Route::get('buku', 'Api\BukuController@index');
    Route::get('buku/{id}', 'Api\BukuController@show');
    Route::post('buku', 'Api\BukuController@store');
    Route::put('buku/{id}', 'Api\BukuController@update');
    Route::delete('buku/{id}', 'Api\BukuController@destroy');

    Route::get('majalah', 'Api\MajalahController@index');
    Route::get('majalah/{id}', 'Api\MajalahController@show');
    Route::post('majalah', 'Api\MajalahController@store');
    Route::put('majalah/{id}', 'Api\MajalahController@update');
    Route::delete('majalah/{id}', 'Api\MajalahController@destroy');
    
    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');

    Route::post('logout', 'Api\AuthController@logout');
});


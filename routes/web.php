<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('file', [App\Http\Controllers\AuthfileController::class,'getFile'])->name('file');

Route::get('/otp', [App\Http\Controllers\Auth\userController::class,'otp'])->name('otp');
Route::get('/resendotp', [App\Http\Controllers\Auth\userController::class,'resendotp'])->name('resendotp');
Route::post('/verifyotp', [App\Http\Controllers\Auth\userController::class,'verifyOtp'])->name('verifyotp');
Route::get('/mailotp', [App\Http\Controllers\Auth\userController::class,'mailotp'])->name('mailotp');


Route::group(['middleware' => ['auth', 'UserValidated']], function () {
    Route::get('admin/{path}', function () {
        return view('admin');
    })->where('path', '[A-Za-z]+');
    Route::get('admin', function () {
        return view('admin');
    })->where('path', '[A-Za-z]+');
});


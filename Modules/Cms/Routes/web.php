<?php

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

Route::group(['middleware' => ['auth', 'UserValidated']], function () {
    // Route::get('/', 'CmsController@index');
    Route::get('cms/{path}', function () {
        return view('admin');
    })->where('path', '[A-Za-z]+');
    Route::get('cms/{blog}/{id}', function () {
        return view('admin');
    })->where('path', '[A-Za-z]+');
});

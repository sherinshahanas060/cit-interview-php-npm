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

// Route::prefix('report')->group(function() {
//     Route::get('/', 'ReportController@index');
// });

Route::group(['middleware' => ['auth', 'UserValidated']], function () {
    Route::get('report/{path}', function () {
        return view('admin');
    })->where('path', '[A-Za-z]+');
   
});
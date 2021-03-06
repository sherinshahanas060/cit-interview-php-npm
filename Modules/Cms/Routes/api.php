<?php

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

// Route::middleware('auth:api')->get('/cms', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'blogapi' => 'API\BlogsController',
    ]);

    Route::get('blogview/{id}/', 'API\BlogsController@view')->name('blogapi.view');
});

Route::group(['middleware' => 'client'], function () {
    Route::apiResources([
        'blogs' => 'API\External\BlogsController',
    ]);
});

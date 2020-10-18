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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'rolepermissionapi' => 'API\RolePermissionController',
        'usermanageapi' => 'API\UserManageController',
        'webuserapi' => 'API\WebUserController'
    ]);
    Route::post('storeRole', 'API\RolePermissionController@storeRole')->name('rolepermissionapi.storerole');
    Route::put('updateRole/{id}', 'API\RolePermissionController@updateRole')->name('rolepermissionapi.updaterole');
    Route::delete('destroyRole/{id}', 'API\RolePermissionController@destroyRole')->name('rolepermissionapi.destroyrole');
    Route::post('syncPermissionToRole', 'API\RolePermissionController@syncPermissionToRole')->name('rolepermissionapi.syncpermissiontorole');
    Route::get('getUserPermissions', 'API\RolePermissionController@getUserPermissions')->name('rolepermissionapi.userpermissions');
    Route::get('getAllRoles', 'API\RolePermissionController@getAllRoles')->name('rolepermissionapi.getallroles');

    Route::get('showUserDetailsByUserId/{userId}/', 'API\UserManageController@showUserDetailsByUserId')->name('usermanageapi.showuserdetailsbyuserid');
    Route::get('getUsers/', 'API\UserManageController@getUsers')->name('usermanageapi.getusers');
    Route::get('getdelegates/', 'API\UserManageController@getDelegates')->name('usermanageapi.getdelegates');
    Route::get('showMyProfile/{id}', 'API\UserManageController@showMyProfile')->name('usermanageapi.showmyprofile');
    Route::put('updateMyProfile/{id}', 'API\UserManageController@updateMyProfile')->name('usermanageapi.updatemyprofile');
    Route::get('viewMyProfile/{id}', 'API\UserManageController@viewMyProfile')->name('usermanageapi.viewmyprofile');
    Route::get('useroptions', 'API\UserManageController@userOptions')->name('usermanageapi.useroptions');
});

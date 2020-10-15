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

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'todotaskapi' => 'API\ToDoTaskController',
        'priorityapi' => 'API\PriorityController',
    ]);

    Route::get('todoView/{id}', 'API\ToDoTaskController@view')->name('todotaskapi.view');
    Route::delete('removeToDoUser/{mapId}', 'API\ToDoTaskController@removeToDoUser')->name('todotaskapi.removetodouser');
    Route::get('getStatus', 'API\ToDoTaskController@getStatus')->name('todotaskapi.getstatus');
    Route::post('addToDoStatus/{status}', 'API\ToDoTaskController@addToDoStatus')->name('todotaskapi.addtodostatus');
    Route::put('updateToDoCompleted/{status}', 'API\ToDoTaskController@updateCompleted')->name('todotaskapi.updateToDoCompleted');
    Route::post('forwardTodo', 'API\ToDoTaskController@forwardTodo')->name('todotaskapi.forwardtodo');
    Route::match(array('GET', 'POST'), 'teamtaskIndex', 'API\ToDoTaskController@teamtaskIndex')->name('todotaskapi.teamtaskIndex');
    Route::match(array('GET', 'POST'), 'todoCompleted', 'API\ToDoTaskController@todoCompletedIndex')->name('todotaskapi.todocompletedindex');
    Route::get('getuserCount', 'API\ToDoTaskController@getuserCount')->name('todotaskapi.getuserCount');
});

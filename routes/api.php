<?php

use Illuminate\Http\Request;

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

/**
 * Set prefix /v1 in all API routes
 */
Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    /**
     * Tasks API Routes
     */
    Route::resource('tasks', 'TasksController', ['except' => 'create', 'edit']);
});
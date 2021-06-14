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
Route::group(['namespace'=>'Api'], function() {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/user/create', 'Auth\LoginController@createUser');

    Route::get('/creators','Youtube@getCreators');
    Route::get("/creator/youtube/{creatorId}",[\App\Http\Controllers\Api\Youtube::class,"getVideos"]);
    });

Route::group(['namespace'=>'Api','middleware' => 'auth:api'], function () {
    Route::get("/info","UserController@getUserInfo");
    Route::get("/profile/{userId}", "UserController@userProfile");
    Route::delete("/profile/{userId}",[\App\Http\Controllers\Api\UserController::class, "deleteUser"]);
});


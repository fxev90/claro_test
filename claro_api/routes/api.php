<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'App\Http\Controllers\Api'], function(){
    Route::group(['prefix'=>'auth'], function () {
        Route::post('register', 'AuthenticationController@register');
        Route::post('login', 'AuthenticationController@login');
    });
    Route::post('/logout', 'AuthenticationController@logout')->middleware('auth:sanctum');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

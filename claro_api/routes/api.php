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

/*===========================
=           students           =
=============================*/

Route::apiResource('/students', \App\Http\Controllers\API\StudentController::class);
Route::group([
   'prefix' => 'students',
], function() {
    Route::get('{id}/restore', [\App\Http\Controllers\API\StudentController::class, 'restore']);
    Route::delete('{id}/permanent-delete', [\App\Http\Controllers\API\StudentController::class, 'permanentDelete']);
});
/*=====  End of students   ======*/

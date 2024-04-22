<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseStudentController;

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

/*===========================
=           courses           =
=============================*/

Route::apiResource('/courses', \App\Http\Controllers\API\CourseController::class);
Route::group([
   'prefix' => 'courses',
], function() {
    Route::get('{id}/restore', [\App\Http\Controllers\API\CourseController::class, 'restore']);
    Route::delete('{id}/permanent-delete', [\App\Http\Controllers\API\CourseController::class, 'permanentDelete']);
});
/*=====  End of courses   ======*/

Route::post('/courses/{course}/students/{student}', [CourseStudentController::class, 'enrollStudent']);
Route::get('/top-courses', [CourseStudentController::class, 'topCourses']);
Route::get('/top-students', [CourseStudentController::class, 'topStudents']);
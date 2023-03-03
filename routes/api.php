<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\ReplySupportController;
use App\Http\Controllers\Api\SupportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/courses/{id}', [CourseController::class, 'find']);
Route::get('/courses', [CourseController::class, 'index']);

Route::get('/courses/{id}/modules', [ModuleController::class, 'index']);

Route::get('/modules/{id}/lessons', [LessonController::class, 'index']);
Route::get('/lessons/{id}', [LessonController::class, 'show']);

Route::get('/supports', [SupportController::class, 'index']);
Route::get('/supports/my', [SupportController::class, 'mySupports']);
Route::post('/supports', [SupportController::class, 'store']);

Route::post('/replies', [ReplySupportController::class, 'createReply']);

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);

    Route::apiResource('task-lists', TaskListController::class);
    Route::post('/task-lists/{taskList}/share', [TaskListController::class, 'share']);
    Route::get('/shared-lists', [TaskListController::class, 'sharedLists']);

    Route::apiResource('task-lists.tasks', TaskController::class)->shallow();
});
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/validate-token', [AuthController::class, 'validateToken']);
    Route::delete('/delete', [AuthController::class, 'destroy']);

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/byid', [TaskController::class, 'getById']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::delete('/tasks', [TaskController::class, 'destroy']);
    Route::put('/tasks', [TaskController::class, 'update']);
    Route::put('/tasks/status', [TaskController::class, 'updateStatus']);

    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::put('/items', [ItemController::class, 'update']);
    Route::put('/items/status', [ItemController::class, 'updateStatus']);
    Route::delete('/items', [ItemController::class, 'destroy']);
});





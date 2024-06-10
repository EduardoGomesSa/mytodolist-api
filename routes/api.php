<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::delete('/tasks', [TaskController::class, 'destroy']);
Route::put('/tasks', [TaskController::class, 'update']);
Route::put('/tasks/status', [TaskController::class, 'updateStatus']);

Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);
Route::put('/items', [ItemController::class, 'update']);
Route::put('/items/status', [ItemController::class, 'updateStatus']);

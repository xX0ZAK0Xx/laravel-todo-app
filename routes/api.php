<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/sign-in', [AuthController::class, 'signIn']);
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/sign-out', [AuthController::class, 'signOut']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('todos', TodoController::class);
    Route::patch('todos/{id}/complete', [TodoController::class, 'complete']);
});

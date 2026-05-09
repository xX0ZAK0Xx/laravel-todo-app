<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

//! Auth
// POST /api/v1/user/auth/sign-out
Route::post('auth/sign-out', [AuthController::class, 'signOut']);
// GET /api/v1/user/auth/me
Route::get('auth/me', [AuthController::class, 'me']);

//! Profile
// GET /api/v1/user/profile
Route::get('profile', [ProfileController::class, 'show']);
// PUT /api/v1/user/profile
Route::put('profile', [ProfileController::class, 'update']);

//! Todos
Route::apiResource('todos', TodoController::class);
Route::patch('todos/{id}/complete', [TodoController::class, 'complete']);

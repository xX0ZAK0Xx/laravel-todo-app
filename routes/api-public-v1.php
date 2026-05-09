<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

// POST /api/v1/public/register
Route::post('register', [AuthController::class, 'register']);

// POST /api/v1/public/sign-in
Route::post('sign-in', [AuthController::class, 'signIn']);

// GET /api/v1/public/health
Route::get('health', [HealthController::class, 'index']);
<?php

use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

// User management
Route::apiResource('users', AdminUserController::class)->only(['index', 'show', 'destroy']);

// Statistics
Route::get('stats', [StatsController::class, 'index']);
Route::get('stats/todos', [StatsController::class, 'todos']);
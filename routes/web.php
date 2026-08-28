<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name'    => config('app.name'),
        'status'  => 'ok',
        'message' => 'API only. See routes/api-*.php for available endpoints.',
    ]);
});

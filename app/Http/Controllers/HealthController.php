<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            $dbStatus = 'connected';
        } catch (\Throwable $th) {
            $dbStatus = 'disconnected';
        }

        return $this->success([
            'status'    => $dbStatus,
            'version'   => '1.0.0',
            'timestamp' => now()->toDateTimeString(),
        ], 'Health check');
    }
}

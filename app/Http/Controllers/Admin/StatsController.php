<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatsService;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    public function __construct(private StatsService $statsService) {}

    public function index(): JsonResponse
    {
        return $this->success($this->statsService->getOverall(), 'Stats retrieved successfully');
    }

    public function todos(): JsonResponse
    {
        $completions = $this->statsService->getTodoCompletions();
        return $this->success(['data' => $completions], 'Todo completions retrieved successfully');
    }
}
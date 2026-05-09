<?php

namespace App\Services;

use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

class StatsService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TodoRepositoryInterface $todoRepository,
    ) {}

    public function getOverall(): array
    {
        return [
            'users' => [
                'total'  => $this->userRepository->count(),
                'admins' => $this->userRepository->countAdmins(),
            ],
            'todos' => [
                'total'     => $this->todoRepository->count(),
                'completed' => $this->todoRepository->countCompleted(),
                'active'    => $this->todoRepository->countActive(),
            ],
        ];
    }

    public function getTodoCompletions(): Collection
    {
        return $this->todoRepository->completionsPerDay(7);
    }
}

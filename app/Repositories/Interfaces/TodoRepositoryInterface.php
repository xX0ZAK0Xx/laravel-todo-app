<?php
namespace App\Repositories\Interfaces;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepositoryInterface
{
    public function getAllForUser(int $userId): Collection;
    public function countActiveForUser(int $userId): int;
    public function findById(int $id): Todo;
    public function create(array $data): Todo;
    public function update(Todo $todo, array $data): Todo;
    public function delete(Todo $todo): bool;
    public function count(): int;
    public function countCompleted(): int;
    public function countActive(): int;
    public function completionsPerDay(int $days): \Illuminate\Support\Collection;
}
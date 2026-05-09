<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function findById(int $id): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function count(): int;
    public function countAdmins(): int;
}

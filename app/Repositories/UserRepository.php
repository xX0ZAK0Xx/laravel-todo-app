<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return User::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function count(): int
    {
        return User::count();
    }

    public function countAdmins(): int
    {
        return User::where('is_admin', true)->count();
    }
}

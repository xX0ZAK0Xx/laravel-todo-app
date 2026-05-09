<?php
namespace App\Repositories;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AuthRepository implements AuthRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return (bool) User::destroy($user->getKey());
    }
}
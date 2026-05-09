<?php
namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AuthRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
}
<?php
namespace App\Repositories\Interfaces;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): Todo;
    public function create(array $data): Todo;
    public function update(Todo $todo, array $data): Todo;
    public function delete(Todo $todo): bool;
}
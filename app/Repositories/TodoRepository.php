<?php
namespace App\Repositories;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository implements TodoRepositoryInterface
{
    public function getAll(): Collection
    {
        return Todo::orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): Todo
    {
        return Todo::findOrFail($id);
    }

    public function create(array $data): Todo
    {
        return Todo::create($data);
    }

    public function update(Todo $todo, array $data): Todo
    {
        $todo->update($data);
        return $todo->fresh();
    }

    public function delete(Todo $todo): bool
    {
        return (bool) Todo::destroy($todo->getKey());
    }
}
<?php
namespace App\Repositories;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository implements TodoRepositoryInterface
{
    public function getAllForUser(int $userId): Collection
    {
        return Todo::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    public function countActiveForUser(int $userId): int
    {
        return Todo::where('user_id', $userId)->where('is_done', false)->count();
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

    public function count(): int
    {
        return Todo::count();
    }

    public function countCompleted(): int
    {
        return Todo::where('is_done', true)->count();
    }

    public function countActive(): int
    {
        return Todo::where('is_done', false)->count();
    }

    public function completionsPerDay(int $days): \Illuminate\Support\Collection
    {
        return Todo::where('is_done', true)
            ->where('completed_at', '>=', now()->subDays($days))
            ->selectRaw('DATE(completed_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
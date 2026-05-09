<?php

namespace App\Services;

use App\Events\TodoCompleted;
use App\Exceptions\BusinessException;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TodoService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private TodoRepositoryInterface $repository){}

    public function getAllForUser(User $user): Collection
    {
        return $this->repository->getAllForUser($user->id);
    }

    public function getByIdForUser(User $user, int $id): Todo
    {
        $todo = $this->repository->findById($id);

        $this->authoriseTodoOwner($user, $todo);

        return $todo;
    }

    public function create(User $user, array $todo): Todo
    {
        // maximum 10 todos per user
        $existingTodos = $this->repository->countActiveForUser($user->id);
        if ($existingTodos >= 10) {
            throw new BusinessException("Max Limit Reached", 400);
        }

        $todo["user_id"] = $user->id;
        return $this->repository->create($todo);
    }

    public function update(User $user, int $id, array $data): Todo
    {
        $todo = $this->getByIdForUser($user, $id);

        return $this->repository->update($todo, $data);
    }

    public function completeTodo(User $user, int $id): Todo
    {
        $todo = $this->getByIdForUser($user, $id);
        
        // can't complete an already completed todo
        if ($todo->is_done) {
            throw new BusinessException("Todo is already completed", 400);
        }

        TodoCompleted::dispatch($todo, $user);

        // mark todo is done and add completed_at timestamp
        return $this->repository->update($todo, [
            'is_done' => true,
            'completed_at' => now(),
        ]);
    }

    public function delete(User $user, int $id): Todo
    {
        $todo = $this->getByIdForUser($user, $id);

        $this->repository->delete($todo);
        return $todo;
    }

    private function authoriseTodoOwner(User $user, Todo $todo): void
    {
        if ($todo->user_id !== $user->id) {
            throw new BusinessException(
                'You do not have permission to modify this todo.',
                403
            );
        }
    }
}

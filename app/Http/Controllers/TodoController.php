<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // public function __construct(private TodoRepositoryInterface $todoRepository) {}
    public function __construct(private TodoService $todoService) {}

    //GET /api/todos -> Get all todos
    public function index(Request $request): JsonResponse{
        $todos = $this->todoService->getAllForUser($request->user());
        return $this->success(TodoResource::collection($todos), 'Todos retrieved successfully', 200);
    }

    //POST /api/todos -> Create a new todo
    public function store(StoreTodoRequest $request): JsonResponse{
        $todo = $this->todoService->create($request->user(), $request->validated());
        return $this->created(new TodoResource($todo), 'Todo created successfully');
    }

    //GET /api/todos/{id} -> Get a specific todo
    public function show(Request $request, int $id): JsonResponse{
        $todo = $this->todoService->getByIdForUser($request->user(), $id);
        return $this->success(new TodoResource($todo), 'Todo retrieved successfully', 200);
    }

    //PUT /api/todos/{id} -> Update a specific todo
    public function update(UpdateTodoRequest $request, int $id): JsonResponse{
        $todo = $this->todoService->update($request->user(), $id, $request->validated());
        return $this->success(new TodoResource($todo), 'Todo updated successfully', 200);
    }

    //PATCH /api/todos/{id}/complete -> Mark a specific todo as complete
    public function complete(Request $request, int $id): JsonResponse
    {
        $todo = $this->todoService->completeTodo($request->user(), $id);
        return $this->success(new TodoResource($todo), 'Todo marked as complete', 200);
    }

    //DELETE /api/todos/{id} -> Delete a specific todo
    public function destroy(Request $request, int $id): JsonResponse{
        $this->todoService->delete($request->user(), $id);
        return $this->noContent();
    }
}

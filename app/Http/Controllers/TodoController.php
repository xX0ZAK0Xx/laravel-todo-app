<?php

namespace App\Http\Controllers;

use App\Models\Todo;
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
        return TodoResource::collection($todos)->additional(['meta' => ['total' => $todos->count()]])->response();
    }

    //POST /api/todos -> Create a new todo
    public function store(StoreTodoRequest $request): JsonResponse{
        $todo = $this->todoService->create($request->user(), $request->validated());
        return response()->json(new TodoResource($todo), 201);
    }

    //GET /api/todos/{id} -> Get a specific todo
    public function show(Request $request, int $id): JsonResponse{
        $todo = $this->todoService->getByIdForUser($request->user(), $id);
        return response()->json(new TodoResource($todo));
    }

    //PUT /api/todos/{id} -> Update a specific todo
    public function update(UpdateTodoRequest $request, int $id): JsonResponse{
        $todo = $this->todoService->update($request->user(), $id, $request->validated());
        return response()->json(new TodoResource($todo));
    }

    //PATCH /api/todos/{id}/complete -> Mark a specific todo as complete
    public function complete(Request $request, int $id): JsonResponse
    {
        $todo = $this->todoService->completeTodo($request->user(), $id);
        return response()->json(new TodoResource($todo));
    }

    //DELETE /api/todos/{id} -> Delete a specific todo
    public function destroy(Request $request, int $id): JsonResponse{
        $this->todoService->delete($request->user(), $id);
        return response()->json(null, 204);
    }
}

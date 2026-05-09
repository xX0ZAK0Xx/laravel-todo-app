<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {}
    //GET /api/todos -> Get all todos
    public function index(Request $request): JsonResponse{
        // $todos = Todo::all();
        $todos = $this->todoRepository->getAllForUser($request->user()->id);
        // return response()->json($todos);
        return TodoResource::collection($todos)->additional(['meta' => ['total' => $todos->count()]])->response();
    }

    //POST /api/todos -> Create a new todo
    public function store(StoreTodoRequest $request): JsonResponse{
        // $todo = Todo::create([
        //     'title' => $request->input('title'),
        //     'is_done' => false,
        // ]);
        // $todo = $this->todoRepository->create($request->validated());
        $todo = $this->todoRepository->create(
            array_merge(
                $request->validated(),
                ['user_id' => $request->user()->id]
            )
        );
        // return response()->json($todo, 201);
        return response()->json(new TodoResource($todo), 201);
    }

    //GET /api/todos/{id} -> Get a specific todo
    public function show(Todo $todo): JsonResponse{
        // return response()->json($todo);
        $todo = $this->todoRepository->findById($todo->id);
        // return response()->json($todo);
        return response()->json(new TodoResource($todo));
    }

    //PUT /api/todos/{id} -> Update a specific todo
    public function update(UpdateTodoRequest $request, Todo $todo): JsonResponse{
        // $todo-> update($request->only(['title', 'is_done']));
        $todo = $this->todoRepository->update($todo, $request->validated());
        // return response()->json($todo);
        return response()->json(new TodoResource($todo));
    }

    //DELETE /api/todos/{id} -> Delete a specific todo
    public function destroy(Todo $todo): JsonResponse{
        // $todo->delete();
        $this->todoRepository->delete($todo);
        return response()->json(null, 204);
    }
}

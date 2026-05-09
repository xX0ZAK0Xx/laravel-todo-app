<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    // GET api/v1/admin/users
    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();
        return $this->success([
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ],
        ], 'Users retrieved successfully');
    }

    // GET api/v1/admin/users/{id}
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->findById($id);
        return $this->success(new UserResource($user), 'User retrieved successfully');
    }

    // DELETE api/v1/admin/users/{id}
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->userService->delete($request->user(), $id);
        return $this->noContent();
    }
}

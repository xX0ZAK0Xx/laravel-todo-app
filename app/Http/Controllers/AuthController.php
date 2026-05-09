<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(StoreRegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());
        return $this->created([
            'user' => new UserResource($result['user']),
            'access_token' => $result['token'],
        ], 'User registered successfully');
    }

    public function signIn(SignInRequest $request): JsonResponse
    {
        $result = $this->authService->signIn($request->validated());
        return $this->success([
            'user' => new UserResource($result['user']),
            'access_token' => $result['token'],
        ], 'Signed in successfully');
    }

    public function signOut(Request $request): JsonResponse
    {
        $this->authService->signOut($request->user());
        return $this->success(null, 'Logged out successfully');
    }

    public function me(Request $request): JsonResponse
    {
        return $this->success(new UserResource($request->user()), 'User retrieved successfully');
    }
}

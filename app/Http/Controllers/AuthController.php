<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {}
    public function register(StoreRegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $newUser = $this->authRepository->create($validatedData);
        $token = $newUser->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'user' => new UserResource($newUser),
                'access_token' => $token
            ],
            201
        );
    }

    public function signIn(SignInRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->authRepository->getAll()->where('email', $validatedData['email'])->first();

        // Hash::check is used to compare the provided password with the hashed password stored in the database.
        if(!$user || ! Hash::check($validatedData['password'], $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        // delete existing tokens for single session
        $user->tokens()->delete();
        // create new token
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'user' => new UserResource($user),
                'access_token' => $token
            ],
            200
        );
    }

    public function signOut(Request $request): JsonResponse
    {
        // Delete the user token
        $token = $request->user()?->currentAccessToken();

        $token?->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(new UserResource($request->user()));
    }
}

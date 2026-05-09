<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function register(array $data): array
    {
        $user = $this->authRepository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return compact('user', 'token');
    }

    public function signIn(array $data): array
    {
        $user = $this->authRepository->getAll()->where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new BusinessException('Invalid credentials', 401);
        }

        // Single session: delete existing tokens
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return compact('user', 'token');
    }

    public function signOut(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}

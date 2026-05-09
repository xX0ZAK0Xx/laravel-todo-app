<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function updateProfile(User $user, array $data): User
    {
        return $this->userRepository->update($user, $data);
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->getAll($perPage);
    }

    public function findById(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    public function delete(User $requestingUser, int $targetId): void
    {
        $target = $this->userRepository->findById($targetId);

        if ($target->is_admin) {
            throw new BusinessException('Cannot delete admin user', 403);
        }

        if ($requestingUser->id === $target->id) {
            throw new BusinessException('Cannot delete self', 403);
        }

        $this->userRepository->delete($target);
    }
}

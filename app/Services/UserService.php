<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getPaginatedUsers(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->getPaginatedUsers($perPage);
    }

    public function getUserDetails(int $id): ?User
    {
        return $this->userRepository->getUserWithDetails($id);
    }
}

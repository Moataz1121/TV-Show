<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function findByEmail(string $email): ?User;

    public function findById(int $id): ?User;

    public function updateAvatar(User $user, UploadedFile $file): void;

    public function getPaginatedUsers(int $perPage = 10): LengthAwarePaginator;

    public function getUserWithDetails(int $id): ?User;
}

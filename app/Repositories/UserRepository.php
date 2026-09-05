<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user',
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function updateAvatar(User $user, UploadedFile $file): void
    {
        $user->addMedia($file)
            ->toMediaCollection('avatar');
    }

    public function getPaginatedUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::withCount(['tvShows', 'episodeReactions'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getUserWithDetails(int $id): ?User
    {
        return User::with(['tvShows', 'episodeReactions'])
            ->withCount(['tvShows', 'episodeReactions'])
            ->find($id);
    }
}

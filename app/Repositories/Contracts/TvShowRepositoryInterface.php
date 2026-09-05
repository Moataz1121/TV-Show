<?php

namespace App\Repositories\Contracts;

use App\Models\TvShow;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TvShowRepositoryInterface
{
    public function getAll(): Collection;

    public function getAllPaginated(int $perPage = 12): LengthAwarePaginator;

    public function findByIdWithEpisodes(int $id): ?TvShow;

    public function follow(User $user, TvShow $tvShow): void;

    public function unfollow(User $user, TvShow $tvShow): void;

    public function isFollowedBy(TvShow $tvShow, User $user): bool;

    public function search(string $term): Collection;

    public function getRandom(int $limit = 5): Collection;

    public function create(array $data): TvShow;

    public function update(TvShow $tvShow, array $data): TvShow;
}

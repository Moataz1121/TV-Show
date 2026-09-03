<?php

namespace App\Repositories\Contracts;

use App\Models\TvShow;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TvShowRepositoryInterface
{
    public function getAllPaginated(int $perPage = 12): LengthAwarePaginator;

    public function findByIdWithEpisodes(int $id): ?TvShow;

    public function follow(User $user, TvShow $tvShow): void;

    public function unfollow(User $user, TvShow $tvShow): void;

    public function isFollowedBy(TvShow $tvShow, User $user): bool;
}

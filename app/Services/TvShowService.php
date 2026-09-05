<?php

namespace App\Services;

use App\Models\TvShow;
use App\Models\User;
use App\Repositories\Contracts\TvShowRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TvShowService
{
    public function __construct(
        protected TvShowRepositoryInterface $tvShowRepository
    ) {}

    public function getPaginatedShows(int $perPage = 12): LengthAwarePaginator
    {
        return $this->tvShowRepository->getAllPaginated($perPage);
    }

    public function getShowWithEpisodes(int $id): ?TvShow
    {
        return $this->tvShowRepository->findByIdWithEpisodes($id);
    }

    public function followShow(User $user, TvShow $tvShow): void
    {
        $this->tvShowRepository->follow($user, $tvShow);
    }

    public function unfollowShow(User $user, TvShow $tvShow): void
    {
        $this->tvShowRepository->unfollow($user, $tvShow);
    }

    public function isUserFollowing(?User $user, TvShow $tvShow): bool
    {
        if (! $user) {
            return false;
        }

        return $this->tvShowRepository->isFollowedBy($tvShow, $user);
    }

    public function getRandomShows(int $limit = 5): Collection
    {
        return $this->tvShowRepository->getRandom($limit);
    }
}

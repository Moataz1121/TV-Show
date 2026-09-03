<?php

namespace App\Services;

use App\Models\TvShow;
use App\Repositories\Contracts\TvShowRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
}

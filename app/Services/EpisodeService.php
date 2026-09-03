<?php

namespace App\Services;

use App\Models\Episode;
use App\Repositories\Contracts\EpisodeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EpisodeService
{
    public function __construct(
        protected EpisodeRepositoryInterface $episodeRepository
    ) {}

    public function getLatestEpisodes(int $limit = 6): Collection
    {
        return $this->episodeRepository->getLatest($limit);
    }

    public function getEpisodeWithTvShow(int $id): ?Episode
    {
        return $this->episodeRepository->findByIdWithTvShow($id);
    }
}

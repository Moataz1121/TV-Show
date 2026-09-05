<?php

namespace App\Services;

use App\Repositories\Contracts\EpisodeRepositoryInterface;
use App\Repositories\Contracts\TvShowRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function __construct(
        protected TvShowRepositoryInterface $tvShowRepository,
        protected EpisodeRepositoryInterface $episodeRepository
    ) {}

    /**
     * Search TV Shows and Episodes by term.
     *
     * @return array{shows: Collection, episodes: Collection, query: string}
     */
    public function search(?string $query): array
    {
        $query = trim((string) $query);

        if (empty($query)) {
            return [
                'shows' => new Collection(),
                'episodes' => new Collection(),
                'query' => '',
            ];
        }

        $shows = $this->tvShowRepository->search($query);
        $episodes = $this->episodeRepository->search($query);

        return [
            'shows' => $shows,
            'episodes' => $episodes,
            'query' => $query,
        ];
    }
}

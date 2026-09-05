<?php

namespace App\Repositories\Contracts;

use App\Models\Episode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EpisodeRepositoryInterface
{
    public function getLatest(int $limit = 6): Collection;

    public function findByIdWithTvShow(int $id): ?Episode;

    public function search(string $term): Collection;

    public function getPaginatedEpisodes(int $perPage = 10): LengthAwarePaginator;

    public function getEpisodeDetails(int $id): ?Episode;

    public function create(array $data): Episode;

    public function update(Episode $episode, array $data): Episode;
}

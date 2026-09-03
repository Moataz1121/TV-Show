<?php

namespace App\Repositories\Contracts;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Collection;

interface EpisodeRepositoryInterface
{
    public function getLatest(int $limit = 6): Collection;

    public function findByIdWithTvShow(int $id): ?Episode;
}

<?php

namespace App\Repositories\Contracts;

use App\Models\TvShow;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TvShowRepositoryInterface
{
    public function getAllPaginated(int $perPage = 12): LengthAwarePaginator;

    public function findByIdWithEpisodes(int $id): ?TvShow;
}

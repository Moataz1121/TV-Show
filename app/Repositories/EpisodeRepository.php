<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Repositories\Contracts\EpisodeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EpisodeRepository implements EpisodeRepositoryInterface
{
    public function getLatest(int $limit = 6): Collection
    {
        return Episode::with('tvShow')
            ->orderBy('airing_time', 'desc')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function findByIdWithTvShow(int $id): ?Episode
    {
        return Episode::with('tvShow')->find($id);
    }

    public function search(string $term): Collection
    {
        return Episode::with('tvShow')
            ->where(function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%")
                      ->orWhere('description', 'LIKE', "%{$term}%");
            })
            ->get();
    }
}

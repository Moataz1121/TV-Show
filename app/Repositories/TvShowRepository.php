<?php

namespace App\Repositories;

use App\Models\TvShow;
use App\Models\User;
use App\Repositories\Contracts\TvShowRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TvShowRepository implements TvShowRepositoryInterface
{
    public function getAllPaginated(int $perPage = 12): LengthAwarePaginator
    {
        return TvShow::withCount('episodes')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findByIdWithEpisodes(int $id): ?TvShow
    {
        return TvShow::with(['episodes' => function ($query) {
            $query->orderBy('airing_time', 'asc');
        }])->find($id);
    }

    public function follow(User $user, TvShow $tvShow): void
    {
        $user->tvShows()->syncWithoutDetaching([$tvShow->id]);
    }

    public function unfollow(User $user, TvShow $tvShow): void
    {
        $user->tvShows()->detach($tvShow->id);
    }

    public function isFollowedBy(TvShow $tvShow, User $user): bool
    {
        return $user->tvShows()->where('tv_show_id', $tvShow->id)->exists();
    }
}

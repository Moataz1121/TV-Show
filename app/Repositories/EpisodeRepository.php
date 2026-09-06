<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\User;
use App\Repositories\Contracts\EpisodeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EpisodeRepository implements EpisodeRepositoryInterface
{
    public function getLatest(int $limit = 6): Collection
    {
        return Episode::with('tvShow')
            ->aired()
            ->orderBy('airing_time', 'desc')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getEpisodesFromFollowedShows(User $user, int $limit = 6): Collection
    {
        $followedShowIds = $user->tvShows()->pluck('tv_shows.id');

        if ($followedShowIds->isEmpty()) {
            return new Collection();
        }

        return Episode::with('tvShow')
            ->aired()
            ->whereIn('tv_show_id', $followedShowIds)
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
            ->aired()
            ->where(function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%")
                      ->orWhere('description', 'LIKE', "%{$term}%");
            })
            ->get();
    }

    public function getPaginatedEpisodes(int $perPage = 10): LengthAwarePaginator
    {
        return Episode::with('tvShow')
            ->withCount('episodeReactions')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function getEpisodeDetails(int $id): ?Episode
    {
        return Episode::with('tvShow')
            ->withCount([
                'episodeReactions as likes_count' => fn($query) => $query->where('type', 'like'),
                'episodeReactions as dislikes_count' => fn($query) => $query->where('type', 'dislike'),
            ])
            ->find($id);
    }

    public function create(array $data): Episode
    {
        return Episode::create($data);
    }

    public function update(Episode $episode, array $data): Episode
    {
        $episode->update($data);

        return $episode;
    }
}

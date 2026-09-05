<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\EpisodeReaction;
use App\Models\User;
use App\Repositories\Contracts\EpisodeReactionRepositoryInterface;

class EpisodeReactionRepository implements EpisodeReactionRepositoryInterface
{
    public function getUserReaction(User $user, Episode $episode): ?EpisodeReaction
    {
        return EpisodeReaction::where('user_id', $user->id)
            ->where('episode_id', $episode->id)
            ->first();
    }

    public function setReaction(User $user, Episode $episode, string $type): EpisodeReaction
    {
        return EpisodeReaction::updateOrCreate(
            [
                'user_id' => $user->id,
                'episode_id' => $episode->id,
            ],
            [
                'type' => $type,
            ]
        );
    }

    public function removeReaction(User $user, Episode $episode): bool
    {
        return (bool) EpisodeReaction::where('user_id', $user->id)
            ->where('episode_id', $episode->id)
            ->delete();
    }

    public function getReactionCounts(Episode $episode): array
    {
        $likes = EpisodeReaction::where('episode_id', $episode->id)
            ->where('type', 'like')
            ->count();

        $dislikes = EpisodeReaction::where('episode_id', $episode->id)
            ->where('type', 'dislike')
            ->count();

        return [
            'likes' => $likes,
            'dislikes' => $dislikes,
        ];
    }
}

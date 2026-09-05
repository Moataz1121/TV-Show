<?php

namespace App\Repositories\Contracts;

use App\Models\Episode;
use App\Models\EpisodeReaction;
use App\Models\User;

interface EpisodeReactionRepositoryInterface
{
    public function getUserReaction(User $user, Episode $episode): ?EpisodeReaction;

    public function setReaction(User $user, Episode $episode, string $type): EpisodeReaction;

    public function removeReaction(User $user, Episode $episode): bool;

    public function getReactionCounts(Episode $episode): array;
}

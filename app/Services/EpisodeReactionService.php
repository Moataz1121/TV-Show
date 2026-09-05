<?php

namespace App\Services;

use App\Models\Episode;
use App\Models\User;
use App\Repositories\Contracts\EpisodeReactionRepositoryInterface;

class EpisodeReactionService
{
    public function __construct(
        protected EpisodeReactionRepositoryInterface $reactionRepository
    ) {}

    /**
     * Handle user reaction logic (like/dislike/remove/toggle).
     *
     * @return string|null Returns the new type ('like'|'dislike') or null if removed.
     */
    public function react(User $user, Episode $episode, string $type): ?string
    {
        $existing = $this->reactionRepository->getUserReaction($user, $episode);

        if ($existing && $existing->type === $type) {
            // Clicked currently active reaction -> remove reaction
            $this->reactionRepository->removeReaction($user, $episode);
            return null;
        }

        // Clicked new or opposite reaction -> set / update reaction
        $this->reactionRepository->setReaction($user, $episode, $type);
        return $type;
    }

    public function getUserReaction(?User $user, Episode $episode): ?string
    {
        if (! $user) {
            return null;
        }

        return $this->reactionRepository->getUserReaction($user, $episode)?->type;
    }

    public function getReactionCounts(Episode $episode): array
    {
        return $this->reactionRepository->getReactionCounts($episode);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Services\EpisodeReactionService;
use App\Services\EpisodeService;
use Illuminate\View\View;

class EpisodeController extends Controller
{
    public function __construct(
        protected EpisodeService $episodeService,
        protected EpisodeReactionService $reactionService
    ) {}

    public function show(Episode $episode): View
    {
        $episode = $this->episodeService->getEpisodeWithTvShow($episode->id) ?? $episode;
        $userReaction = $this->reactionService->getUserReaction(auth()->user(), $episode);
        $reactionCounts = $this->reactionService->getReactionCounts($episode);

        return view('episodes.show', compact('episode', 'userReaction', 'reactionCounts'));
    }
}

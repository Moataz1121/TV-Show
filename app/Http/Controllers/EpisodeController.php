<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Services\EpisodeService;
use Illuminate\View\View;

class EpisodeController extends Controller
{
    public function __construct(
        protected EpisodeService $episodeService
    ) {}

    public function show(Episode $episode): View
    {
        $episode = $this->episodeService->getEpisodeWithTvShow($episode->id) ?? $episode;

        return view('episodes.show', compact('episode'));
    }
}

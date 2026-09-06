<?php

namespace App\Http\Controllers;

use App\Services\EpisodeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected EpisodeService $episodeService
    ) {}

    public function index(): View
    {
        $latestEpisodes = $this->episodeService->getLatestEpisodes(6);
        $followedEpisodes = auth()->check()
            ? $this->episodeService->getEpisodesFromFollowedShows(auth()->user(), 6)
            : new Collection();

        return view('home', compact('latestEpisodes', 'followedEpisodes'));
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }
}

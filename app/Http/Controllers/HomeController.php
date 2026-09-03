<?php

namespace App\Http\Controllers;

use App\Services\EpisodeService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected EpisodeService $episodeService
    ) {}

    public function index(): View
    {
        $latestEpisodes = $this->episodeService->getLatestEpisodes(6);

        return view('home', compact('latestEpisodes'));
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }
}

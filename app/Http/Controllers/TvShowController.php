<?php

namespace App\Http\Controllers;

use App\Models\TvShow;
use App\Services\TvShowService;
use Illuminate\View\View;

class TvShowController extends Controller
{
    public function __construct(
        protected TvShowService $tvShowService
    ) {}

    public function index(): View
    {
        $shows = $this->tvShowService->getPaginatedShows(12);

        return view('shows.index', compact('shows'));
    }

    public function show(TvShow $tvShow): View
    {
        $show = $this->tvShowService->getShowWithEpisodes($tvShow->id) ?? $tvShow;
        $isFollowing = $this->tvShowService->isUserFollowing(auth()->user(), $show);

        return view('shows.show', compact('show', 'isFollowing'));
    }
}

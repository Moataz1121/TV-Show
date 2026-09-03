<?php

namespace App\Http\Controllers;

use App\Models\TvShow;
use App\Services\TvShowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TvShowFollowController extends Controller
{
    public function __construct(
        protected TvShowService $tvShowService
    ) {}

    public function store(Request $request, TvShow $tvShow): RedirectResponse
    {
        $this->tvShowService->followShow($request->user(), $tvShow);

        return back()->with('success', 'You are now following ' . $tvShow->title);
    }

    public function destroy(Request $request, TvShow $tvShow): RedirectResponse
    {
        $this->tvShowService->unfollowShow($request->user(), $tvShow);

        return back()->with('success', 'You have unfollowed ' . $tvShow->title);
    }
}

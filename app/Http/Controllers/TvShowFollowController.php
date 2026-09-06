<?php

namespace App\Http\Controllers;

use App\Models\TvShow;
use App\Services\TvShowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TvShowFollowController extends Controller
{
    public function __construct(
        protected TvShowService $tvShowService
    ) {}

    public function store(Request $request, TvShow $tvShow): JsonResponse|RedirectResponse
    {
        $this->tvShowService->followShow($request->user(), $tvShow);

        $message = 'You are now following ' . $tvShow->title;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'isFollowing' => true,
                'message' => $message,
                'followUrl' => route('shows.follow', $tvShow),
                'unfollowUrl' => route('shows.unfollow', $tvShow),
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Request $request, TvShow $tvShow): JsonResponse|RedirectResponse
    {
        $this->tvShowService->unfollowShow($request->user(), $tvShow);

        $message = 'You have unfollowed ' . $tvShow->title;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'isFollowing' => false,
                'message' => $message,
                'followUrl' => route('shows.follow', $tvShow),
                'unfollowUrl' => route('shows.unfollow', $tvShow),
            ]);
        }

        return back()->with('success', $message);
    }
}

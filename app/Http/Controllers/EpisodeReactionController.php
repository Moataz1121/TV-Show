<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Services\EpisodeReactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EpisodeReactionController extends Controller
{
    public function __construct(
        protected EpisodeReactionService $reactionService
    ) {}

    public function store(Request $request, Episode $episode): JsonResponse|RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'string', 'in:like,dislike'],
        ]);

        if (! $episode->isAired()) {
            $message = 'Cannot react to an episode before its airing time.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            return back()->with('error', $message);
        }

        $newType = $this->reactionService->react($request->user(), $episode, $request->input('type'));

        $message = match ($newType) {
            'like' => 'You liked this episode!',
            'dislike' => 'You disliked this episode.',
            default => 'Reaction removed.',
        };

        if ($request->expectsJson() || $request->ajax()) {
            $counts = $this->reactionService->getReactionCounts($episode);

            return response()->json([
                'success' => true,
                'userReaction' => $newType,
                'likesCount' => $counts['likes'],
                'dislikesCount' => $counts['dislikes'],
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}

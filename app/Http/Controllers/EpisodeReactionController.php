<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Services\EpisodeReactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EpisodeReactionController extends Controller
{
    public function __construct(
        protected EpisodeReactionService $reactionService
    ) {}

    public function store(Request $request, Episode $episode): RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'string', 'in:like,dislike'],
        ]);

        $newType = $this->reactionService->react($request->user(), $episode, $request->input('type'));

        $message = match ($newType) {
            'like' => 'You liked this episode!',
            'dislike' => 'You disliked this episode.',
            default => 'Reaction removed.',
        };

        return back()->with('success', $message);
    }
}

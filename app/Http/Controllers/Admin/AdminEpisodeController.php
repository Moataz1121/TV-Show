<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EpisodeRequest;
use App\Models\Episode;
use App\Services\EpisodeService;
use App\Services\TvShowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminEpisodeController extends Controller
{
    public function __construct(
        protected EpisodeService $episodeService,
        protected TvShowService $tvShowService
    ) {}

    public function index(): View
    {
        $episodes = $this->episodeService->getPaginatedEpisodes(10);

        return view('admin.episodes.index', compact('episodes'));
    }

    public function create(): View
    {
        $shows = $this->tvShowService->getAllShows();

        return view('admin.episodes.create', compact('shows'));
    }

    public function store(EpisodeRequest $request): RedirectResponse
    {
        $episode = $this->episodeService->createEpisode(
            $request->validated(),
            $request->file('thumbnail'),
            $request->file('video')
        );

        return redirect()->route('admin.episodes.show', $episode)
            ->with('success', 'Episode created successfully!');
    }

    public function show(Episode $episode): View
    {
        $episode = $this->episodeService->getEpisodeDetails($episode->id) ?? $episode;

        return view('admin.episodes.show', compact('episode'));
    }

    public function edit(Episode $episode): View
    {
        $shows = $this->tvShowService->getAllShows();

        return view('admin.episodes.edit', compact('episode', 'shows'));
    }

    public function update(EpisodeRequest $request, Episode $episode): RedirectResponse
    {
        $this->episodeService->updateEpisode(
            $episode,
            $request->validated(),
            $request->file('thumbnail'),
            $request->file('video')
        );

        return redirect()->route('admin.episodes.show', $episode)
            ->with('success', 'Episode updated successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TvShowRequest;
use App\Models\TvShow;
use App\Services\TvShowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminTvShowController extends Controller
{
    public function __construct(
        protected TvShowService $tvShowService
    ) {}

    public function index(): View
    {
        $shows = $this->tvShowService->getPaginatedShows(10);

        return view('admin.tv-shows.index', compact('shows'));
    }

    public function create(): View
    {
        return view('admin.tv-shows.create');
    }

    public function store(TvShowRequest $request): RedirectResponse
    {
        $show = $this->tvShowService->createShow($request->validated());

        return redirect()->route('admin.tv-shows.show', $show)
            ->with('success', 'TV Show created successfully!');
    }

    public function show(TvShow $tvShow): View
    {
        $show = $this->tvShowService->getShowWithEpisodes($tvShow->id) ?? $tvShow;

        return view('admin.tv-shows.show', compact('show'));
    }

    public function edit(TvShow $tvShow): View
    {
        return view('admin.tv-shows.edit', compact('tvShow'));
    }

    public function update(TvShowRequest $request, TvShow $tvShow): RedirectResponse
    {
        $this->tvShowService->updateShow($tvShow, $request->validated());

        return redirect()->route('admin.tv-shows.show', $tvShow)
            ->with('success', 'TV Show updated successfully!');
    }
}

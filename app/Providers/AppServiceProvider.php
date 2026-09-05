<?php

namespace App\Providers;

use App\Repositories\Contracts\EpisodeReactionRepositoryInterface;
use App\Repositories\Contracts\EpisodeRepositoryInterface;
use App\Repositories\Contracts\TvShowRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EpisodeReactionRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\UserRepository;
use App\Services\TvShowService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TvShowRepositoryInterface::class, TvShowRepository::class);
        $this->app->bind(EpisodeRepositoryInterface::class, EpisodeRepository::class);
        $this->app->bind(EpisodeReactionRepositoryInterface::class, EpisodeReactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $tvShowService = $this->app->make(TvShowService::class);
            $view->with('randomTvShows', $tvShowService->getRandomShows(5));
        });
    }
}

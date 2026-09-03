<?php

namespace App\Providers;

use App\Repositories\Contracts\EpisodeRepositoryInterface;
use App\Repositories\Contracts\TvShowRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EpisodeRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\UserRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

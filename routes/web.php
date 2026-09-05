<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTvShowController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\EpisodeReactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TvShowController;
use App\Http\Controllers\TvShowFollowController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shows', [TvShowController::class, 'index'])->name('shows.index');
Route::get('/shows/{tvShow}', [TvShowController::class, 'show'])->name('shows.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Follow / Unfollow TV Shows
    Route::post('/shows/{tvShow}/follow', [TvShowFollowController::class, 'store'])->name('shows.follow');
    Route::delete('/shows/{tvShow}/unfollow', [TvShowFollowController::class, 'destroy'])->name('shows.unfollow');

    // Watching episodes & reacting requires authentication
    Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');
    Route::post('/episodes/{episode}/reaction', [EpisodeReactionController::class, 'store'])->name('episodes.react');
});

// Protected Admin Area Routes
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin Users Management (Read-Only)
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');

        // Admin TV Shows CRUD (List, Create, View, Edit)
        Route::resource('tv-shows', AdminTvShowController::class)->except(['destroy']);
    });

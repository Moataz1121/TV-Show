<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TvShowController;
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

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Watching episodes requires authentication
    Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');
});

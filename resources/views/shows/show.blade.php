@extends('layouts.app')

@section('title', $show->title)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shows.index') }}">TV Shows</a></li>
        <li class="breadcrumb-item active">{{ $show->title }}</li>
    </ol>
</nav>

<div class="card shadow-sm border-0 rounded-3 mb-5 overflow-hidden">
    <div class="card-body p-4 p-md-5 bg-dark text-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge text-bg-danger text-uppercase mb-2 px-3 py-2">TV Series</span>
                <h1 class="display-5 fw-bold text-white mb-3">{{ $show->title }}</h1>
                <p class="lead text-light mb-4">{{ $show->description }}</p>
                <div class="d-flex align-items-center gap-4 text-white-50">
                    <span>
                        <i class="bi bi-calendar-event me-2 text-danger"></i>
                        Airing: {{ $show->airing_time ? $show->airing_time->format('M d, Y H:i') : 'TBA' }}
                    </span>
                    <span>
                        <i class="bi bi-collection-play me-2 text-danger"></i>
                        {{ $show->episodes->count() }} Episodes
                    </span>
                </div>
            </div>

            <!-- Follow / Unfollow Button Section -->
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                @auth
                    @if($isFollowing)
                        <form method="POST" action="{{ route('shows.unfollow', $show) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg fw-semibold px-4 shadow">
                                <i class="bi bi-heart-fill me-2"></i>Unfollow Show
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('shows.follow', $show) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-lg fw-semibold px-4 shadow">
                                <i class="bi bi-heart me-2"></i>Follow Show
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg fw-semibold px-4 shadow">
                        <i class="bi bi-heart me-2"></i>Login to Follow
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<h3 class="fw-bold mb-4"><i class="bi bi-collection-play-fill text-danger me-2"></i>Episodes</h3>

@if($show->episodes->isEmpty())
    <div class="alert alert-secondary py-4 text-center">
        <i class="bi bi-film fs-3 d-block mb-2"></i>
        No episodes available for this show yet.
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($show->episodes as $episode)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ $episode->thumbnail ?: 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=500&auto=format&fit=crop&q=60' }}"
                             alt="{{ $episode->title }}"
                             class="card-img-top card-img-top-cover">
                        <span class="position-absolute bottom-0 end-0 bg-dark text-white px-2 py-1 m-2 rounded small opacity-75">
                            <i class="bi bi-clock me-1"></i>{{ $episode->duration ? $episode->duration . ' mins' : 'N/A' }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $episode->title }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($episode->description, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $episode->airing_time ? $episode->airing_time->format('M d, Y') : 'TBA' }}
                            </small>
                            <a href="{{ route('episodes.show', $episode) }}" class="btn btn-danger btn-sm px-3 fw-semibold">
                                <i class="bi bi-play-fill me-1"></i>Watch Episode
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

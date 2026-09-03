@extends('layouts.app')

@section('title', 'Homepage - Latest Episodes')

@section('content')
<div class="p-5 mb-5 bg-dark text-white rounded-3 shadow">
    <div class="container-fluid py-2">
        <h1 class="display-5 fw-bold text-danger"><i class="bi bi-tv me-2"></i>Welcome to SHOW.TV</h1>
        <p class="col-md-9 fs-5 text-light mb-4">
            Discover popular TV series, stream latest episodes, follow your favorite shows, and share reactions.
        </p>
        <a href="{{ route('shows.index') }}" class="btn btn-danger btn-lg fw-semibold">
            <i class="bi bi-film me-2"></i>Browse TV Shows
        </a>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0 text-dark">
        <i class="bi bi-play-circle-fill text-danger me-2"></i>Latest Episodes
    </h3>
    <a href="{{ route('shows.index') }}" class="btn btn-outline-secondary btn-sm">View All Shows &rarr;</a>
</div>

@if($latestEpisodes->isEmpty())
    <div class="alert alert-info py-4 text-center">
        <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
        No episodes published yet. Check back soon!
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($latestEpisodes as $episode)
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
                        <small class="text-danger fw-bold text-uppercase mb-1">
                            {{ $episode->tvShow->title }}
                        </small>
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $episode->title }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($episode->description, 90) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $episode->airing_time ? $episode->airing_time->format('M d, Y') : 'TBA' }}
                            </small>
                            <a href="{{ route('episodes.show', $episode) }}" class="btn btn-danger btn-sm px-3 fw-semibold">
                                <i class="bi bi-play-fill me-1"></i>Watch
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

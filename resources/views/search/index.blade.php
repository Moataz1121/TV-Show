@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">
        <i class="bi bi-search text-danger me-2"></i>Search Results
    </h2>
    @if(!empty($query))
        <p class="text-muted mb-0">Showing search results for: <span class="badge text-bg-dark fs-6">"{{ $query }}"</span></p>
    @else
        <p class="text-muted mb-0">Search across TV Shows and Episodes.</p>
    @endif
</div>

@if(empty($query))
    <div class="alert alert-info py-4 text-center">
        <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
        Please enter a search keyword in the search bar to find TV shows and episodes.
    </div>
@elseif($shows->isEmpty() && $episodes->isEmpty())
    <div class="alert alert-warning py-4 text-center">
        <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
        No TV shows or episodes found matching <strong>"{{ $query }}"</strong>.
    </div>
@else
    <!-- TV Shows Results Section -->
    @if($shows->isNotEmpty())
        <div class="mb-5">
            <h4 class="fw-bold mb-3 border-bottom pb-2 text-dark">
                <i class="bi bi-film me-2 text-danger"></i>TV Shows ({{ $shows->count() }})
            </h4>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($shows as $show)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 rounded-3">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0">{{ $show->title }}</h5>
                                    <span class="badge text-bg-danger rounded-pill px-2 py-1 small">
                                        {{ $show->episodes_count }} Episodes
                                    </span>
                                </div>
                                <p class="card-text text-muted small my-2 flex-grow-1">
                                    {{ Str::limit($show->description, 120) }}
                                </p>
                                <div class="mt-3 pt-2 border-top text-end">
                                    <a href="{{ route('shows.show', $show) }}" class="btn btn-dark btn-sm px-3 fw-semibold">
                                        View TV Show &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Episodes Results Section -->
    @if($episodes->isNotEmpty())
        <div class="mb-5">
            <h4 class="fw-bold mb-3 border-bottom pb-2 text-dark">
                <i class="bi bi-collection-play me-2 text-danger"></i>Episodes ({{ $episodes->count() }})
            </h4>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($episodes as $episode)
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
                                    {{ Str::limit($episode->description, 100) }}
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
        </div>
    @endif
@endif
@endsection

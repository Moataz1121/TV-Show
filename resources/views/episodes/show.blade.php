@extends('layouts.app')

@section('title', $episode->title . ' - ' . $episode->tvShow->title)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shows.index') }}">TV Shows</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shows.show', $episode->tvShow) }}">{{ $episode->tvShow->title }}</a></li>
        <li class="breadcrumb-item active">{{ $episode->title }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Video Player Section -->
        <div class="card shadow-lg border-0 rounded-3 overflow-hidden mb-4 bg-black">
            <div class="ratio ratio-16x9">
                @if($episode->video)
                    <video controls poster="{{ $episode->thumbnail }}" class="w-100 h-100">
                        <source src="{{ $episode->video }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark">
                        <i class="bi bi-film fs-1 mb-3 text-danger"></i>
                        <h5 class="fw-bold">Episode Video Player</h5>
                        <p class="text-white-50 small mb-0">Video stream placeholder for {{ $episode->title }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Episode Details & Reactions Section -->
        <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3 border-bottom pb-3">
                <div>
                    <span class="badge text-bg-danger text-uppercase mb-2 px-3 py-2">
                        <i class="bi bi-tv me-1"></i>{{ $episode->tvShow->title }}
                    </span>
                    <h2 class="fw-bold text-dark mb-1">{{ $episode->title }}</h2>
                </div>

                <!-- Reactions Action Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Like Form -->
                    <form method="POST" action="{{ route('episodes.react', $episode) }}">
                        @csrf
                        <input type="hidden" name="type" value="like">
                        <button type="submit"
                                class="btn {{ $userReaction === 'like' ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center gap-2 fw-semibold px-3">
                            <i class="bi {{ $userReaction === 'like' ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i>
                            <span>Like</span>
                            <span class="badge text-bg-light border text-dark ms-1">{{ $reactionCounts['likes'] }}</span>
                        </button>
                    </form>

                    <!-- Dislike Form -->
                    <form method="POST" action="{{ route('episodes.react', $episode) }}">
                        @csrf
                        <input type="hidden" name="type" value="dislike">
                        <button type="submit"
                                class="btn {{ $userReaction === 'dislike' ? 'btn-danger' : 'btn-outline-danger' }} d-flex align-items-center gap-2 fw-semibold px-3">
                            <i class="bi {{ $userReaction === 'dislike' ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-down' }}"></i>
                            <span>Dislike</span>
                            <span class="badge text-bg-light border text-dark ms-1">{{ $reactionCounts['dislikes'] }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="row text-muted mb-3 fs-6">
                <div class="col-md-6 mb-2 mb-md-0">
                    <i class="bi bi-clock text-danger me-1"></i>
                    <strong>Duration:</strong> {{ $episode->duration ? $episode->duration . ' minutes' : 'N/A' }}
                </div>
                <div class="col-md-6">
                    <i class="bi bi-calendar-event text-danger me-1"></i>
                    <strong>Airing Time:</strong> {{ $episode->airing_time ? $episode->airing_time->format('M d, Y H:i') : 'TBA' }}
                </div>
            </div>

            <div class="mb-4 pt-2">
                <h5 class="fw-bold text-dark mb-2">Overview</h5>
                <p class="text-secondary fs-6 lead">{{ $episode->description }}</p>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="{{ route('shows.show', $episode->tvShow) }}" class="btn btn-outline-secondary btn-sm">
                    &larr; Back to {{ $episode->tvShow->title }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

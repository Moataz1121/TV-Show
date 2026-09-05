@extends('layouts.app')

@section('title', 'Admin - Episode: ' . $episode->title)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.episodes.index') }}">Episodes</a></li>
        <li class="breadcrumb-item active">{{ $episode->title }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Main Details Card -->
        <div class="card shadow-sm border-0 rounded-3 mb-4 overflow-hidden">
            <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    @if($episode->tvShow)
                        <a href="{{ route('admin.tv-shows.show', $episode->tvShow) }}" class="badge text-bg-danger text-uppercase mb-2 text-decoration-none">
                            <i class="bi bi-tv me-1"></i>{{ $episode->tvShow->title }}
                        </a>
                    @endif
                    <h3 class="mb-0 fw-bold text-white">{{ $episode->title }}</h3>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.episodes.edit', $episode) }}" class="btn btn-primary btn-sm fw-semibold">
                        <i class="bi bi-pencil me-1"></i>Edit Episode
                    </a>
                    <a href="{{ route('episodes.show', $episode) }}" target="_blank" class="btn btn-outline-light btn-sm fw-semibold">
                        <i class="bi bi-box-arrow-up-right me-1"></i>User Page
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Video Player Preview Section -->
                <div class="card bg-black border-0 rounded-3 overflow-hidden mb-4 shadow">
                    <div class="ratio ratio-16x9">
                        @if($episode->video)
                            <video controls poster="{{ $episode->thumbnail }}" class="w-100 h-100">
                                <source src="{{ $episode->video }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark">
                                <i class="bi bi-film fs-1 mb-2 text-danger"></i>
                                <h6 class="fw-bold">No Video Stream Available</h6>
                                <p class="text-white-50 small mb-0">Upload a video or set a video URL in the edit form.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <!-- Key Episode Info -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="bi bi-info-circle text-danger me-2"></i>Episode Details
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong>Episode ID:</strong> <span class="text-secondary">#{{ $episode->id }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>TV Show:</strong>
                                    @if($episode->tvShow)
                                        <a href="{{ route('admin.tv-shows.show', $episode->tvShow) }}" class="text-danger fw-semibold">
                                            {{ $episode->tvShow->title }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <strong>Duration:</strong> {{ $episode->duration ? $episode->duration . ' minutes' : 'N/A' }}
                                </li>
                                <li class="mb-2">
                                    <strong>Airing Time:</strong> {{ $episode->airing_time ? $episode->airing_time->format('M d, Y H:i') : 'TBA' }}
                                </li>
                                <li>
                                    <strong>Created Date:</strong> {{ $episode->created_at->format('M d, Y H:i') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Reactions & Statistics -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="bi bi-bar-chart-line text-danger me-2"></i>User Engagement Statistics
                            </h6>
                            <div class="row text-center g-3 my-2">
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded border shadow-sm">
                                        <i class="bi bi-hand-thumbs-up-fill text-primary fs-3 d-block mb-1"></i>
                                        <h4 class="fw-bold mb-0 text-dark">{{ $episode->likes_count ?? 0 }}</h4>
                                        <small class="text-muted">Likes</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded border shadow-sm">
                                        <i class="bi bi-hand-thumbs-down-fill text-danger fs-3 d-block mb-1"></i>
                                        <h4 class="fw-bold mb-0 text-dark">{{ $episode->dislikes_count ?? 0 }}</h4>
                                        <small class="text-muted">Dislikes</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spatie Translatable Content Tabs -->
                <div class="card border mb-4">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs" id="contentTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold text-dark" id="view-en-tab" data-bs-toggle="tab" data-bs-target="#view-en" type="button">
                                    🇬🇧 English Version
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold text-dark" id="view-ar-tab" data-bs-toggle="tab" data-bs-target="#view-ar" type="button">
                                    🇸🇦 Arabic Version (العربية)
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content" id="contentTabsContent">
                        <div class="tab-pane fade show active" id="view-en">
                            <h5 class="fw-bold text-dark mb-2">{{ $episode->getTranslation('title', 'en', false) }}</h5>
                            <p class="text-secondary mb-0">{{ $episode->getTranslation('description', 'en', false) }}</p>
                        </div>
                        <div class="tab-pane fade" id="view-ar" dir="rtl">
                            @if($episode->hasTranslation('title', 'ar'))
                                <h5 class="fw-bold text-dark mb-2">{{ $episode->getTranslation('title', 'ar', false) }}</h5>
                                <p class="text-secondary mb-0">{{ $episode->getTranslation('description', 'ar', false) }}</p>
                            @else
                                <em class="text-muted">No Arabic translation provided for this episode yet.</em>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.episodes.index') }}" class="btn btn-outline-secondary">
                        &larr; Back to Episodes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

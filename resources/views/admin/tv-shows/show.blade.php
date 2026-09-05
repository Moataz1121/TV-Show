@extends('layouts.app')

@section('title', 'Admin - TV Show Details: ' . $show->title)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tv-shows.index') }}">TV Shows</a></li>
        <li class="breadcrumb-item active">{{ $show->title }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-film me-2"></i>TV Show Overview</h5>
                <a href="{{ route('admin.tv-shows.edit', $show) }}" class="btn btn-primary btn-sm fw-semibold">
                    <i class="bi bi-pencil me-1"></i>Edit TV Show
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="text-muted mb-1">Title (English)</h6>
                            <p class="fs-5 fw-bold mb-0 text-dark">{{ $show->getTranslation('title', 'en', false) ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100" dir="rtl">
                            <h6 class="text-muted mb-1 text-end">Title (Arabic)</h6>
                            <p class="fs-5 fw-bold mb-0 text-dark text-end">{{ $show->getTranslation('title', 'ar', false) ?: 'غير متوفر' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="text-muted mb-1">Description (English)</h6>
                            <p class="mb-0 text-secondary">{{ $show->getTranslation('description', 'en', false) ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100" dir="rtl">
                            <h6 class="text-muted mb-1 text-end">Description (Arabic)</h6>
                            <p class="mb-0 text-secondary text-end">{{ $show->getTranslation('description', 'ar', false) ?: 'غير متوفر' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <h6 class="text-muted mb-1"><i class="bi bi-calendar-event me-1"></i>Airing Time</h6>
                            <p class="fw-semibold mb-0">{{ $show->airing_time ? $show->airing_time->format('F d, Y \a\t H:i') : 'TBA' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <h6 class="text-muted mb-1"><i class="bi bi-collection-play me-1"></i>Total Episodes</h6>
                            <p class="fw-semibold mb-0">{{ $show->episodes->count() }} Episodes</p>
                        </div>
                    </div>
                </div>

                @if($show->episodes->isNotEmpty())
                    <h5 class="fw-bold mb-3"><i class="bi bi-collection-play-fill text-danger me-2"></i>Related Episodes</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Duration</th>
                                    <th>Airing Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($show->episodes as $episode)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $episode->title }}</td>
                                        <td>{{ $episode->duration ? $episode->duration . ' mins' : 'N/A' }}</td>
                                        <td>{{ $episode->airing_time ? $episode->airing_time->format('M d, Y') : 'TBA' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <a href="{{ route('admin.tv-shows.index') }}" class="btn btn-outline-secondary">
                        &larr; Back to TV Shows List
                    </a>
                    <a href="{{ route('shows.show', $show) }}" class="btn btn-outline-danger" target="_blank">
                        View on Website &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Admin - Episodes Management')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item active">Episodes</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-collection-play me-2 text-danger"></i>Episodes Management</h2>
        <p class="text-muted mb-0">Create, view, and edit TV series episodes.</p>
    </div>
    <a href="{{ route('admin.episodes.create') }}" class="btn btn-danger fw-semibold">
        <i class="bi bi-plus-lg me-1"></i>Create Episode
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="ps-4">ID</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Title</th>
                        <th scope="col">TV Show</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Airing Time</th>
                        <th scope="col" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($episodes as $episode)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $episode->id }}</td>
                            <td>
                                @if($episode->thumbnail)
                                    <img src="{{ $episode->thumbnail }}" alt="{{ $episode->title }}" class="rounded border" style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <span class="badge text-bg-secondary">No image</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $episode->title }}</span>
                                @if($episode->hasTranslation('title', 'ar'))
                                    <small class="text-muted">{{ $episode->getTranslation('title', 'ar') }}</small>
                                @endif
                            </td>
                            <td>
                                @if($episode->tvShow)
                                    <a href="{{ route('admin.tv-shows.show', $episode->tvShow) }}" class="badge text-bg-danger text-decoration-none">
                                        <i class="bi bi-tv me-1"></i>{{ $episode->tvShow->title }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="bi bi-clock me-1"></i>{{ $episode->duration ? $episode->duration . ' mins' : 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $episode->airing_time ? $episode->airing_time->format('M d, Y H:i') : 'TBA' }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.episodes.show', $episode) }}" class="btn btn-outline-dark fw-semibold">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.episodes.edit', $episode) }}" class="btn btn-outline-primary fw-semibold">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No episodes created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($episodes->hasPages())
        <div class="card-footer bg-light d-flex justify-content-center py-3">
            {{ $episodes->links() }}
        </div>
    @endif
</div>
@endsection

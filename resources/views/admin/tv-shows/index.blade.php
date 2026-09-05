@extends('layouts.app')

@section('title', 'Admin - TV Shows Management')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item active">TV Shows</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-film me-2 text-danger"></i>TV Shows Management</h2>
        <p class="text-muted mb-0">Create, view, and edit TV shows and series.</p>
    </div>
    <a href="{{ route('admin.tv-shows.create') }}" class="btn btn-danger fw-semibold">
        <i class="bi bi-plus-lg me-1"></i>Create TV Show
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="ps-4">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Episodes</th>
                        <th scope="col">Airing Time</th>
                        <th scope="col">Created At</th>
                        <th scope="col" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shows as $show)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $show->id }}</td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $show->title }}</span>
                                @if($show->hasTranslation('title', 'ar'))
                                    <small class="text-muted">{{ $show->getTranslation('title', 'ar') }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge text-bg-danger rounded-pill px-3">
                                    {{ $show->episodes_count }} Episodes
                                </span>
                            </td>
                            <td>{{ $show->airing_time ? $show->airing_time->format('M d, Y H:i') : 'TBA' }}</td>
                            <td>{{ $show->created_at->format('M d, Y') }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.tv-shows.show', $show) }}" class="btn btn-outline-dark fw-semibold">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.tv-shows.edit', $show) }}" class="btn btn-outline-primary fw-semibold">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No TV shows created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($shows->hasPages())
        <div class="card-footer bg-light d-flex justify-content-center py-3">
            {{ $shows->links() }}
        </div>
    @endif
</div>
@endsection

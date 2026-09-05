@extends('layouts.app')

@section('title', 'Admin - User Details: ' . $user->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2"></i>User Profile Overview</h5>
                <span class="badge {{ $user->isAdmin() ? 'text-bg-danger' : 'text-bg-secondary' }} text-uppercase px-3 py-2">
                    {{ $user->role }}
                </span>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4 mb-4">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-lg border shadow-sm">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-2"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
                        <small class="text-secondary">
                            <i class="bi bi-calendar-check me-1"></i>Registered on {{ $user->created_at->format('F d, Y \a\t H:i') }}
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="text-muted mb-1">Followed TV Shows</h6>
                            <p class="fs-4 fw-bold mb-0 text-danger">{{ $user->tv_shows_count }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="text-muted mb-1">Episode Reactions</h6>
                            <p class="fs-4 fw-bold mb-0 text-primary">{{ $user->episode_reactions_count }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="text-muted mb-1">Spatie Media Avatar</h6>
                            <p class="fw-semibold mb-0">
                                @if($user->hasMedia('avatar'))
                                    <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Uploaded</span>
                                @else
                                    <span class="text-secondary"><i class="bi bi-info-circle me-1"></i>Default UI-Avatar</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($user->tvShows->isNotEmpty())
                    <h5 class="fw-bold mb-3"><i class="bi bi-heart-fill text-danger me-2"></i>Followed TV Shows</h5>
                    <div class="list-group mb-4">
                        @foreach($user->tvShows as $show)
                            <a href="{{ route('shows.show', $show) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span class="fw-bold">{{ $show->title }}</span>
                                <span class="badge text-bg-secondary rounded-pill">View Show &rarr;</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="d-flex justify-content-start pt-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        &larr; Back to Users List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Admin Sidebar -->
    <div class="col-lg-3 col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden sticky-top" style="top: 20px; z-index: 100;">
            <div class="card-header bg-dark text-white p-3 border-0">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav border border-danger shadow-sm" style="width: 42px; height: 42px;">
                    <div class="overflow-hidden">
                        <h6 class="fw-bold text-white mb-0 text-truncate">{{ Auth::user()->name }}</h6>
                        <span class="badge text-bg-danger text-uppercase px-2 py-1" style="font-size: 0.65rem;">
                            <i class="bi bi-shield-lock me-1"></i>Administrator
                        </span>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-flush py-2">
                <div class="px-3 pt-2 pb-1 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    Navigation
                </div>

                <a href="{{ route('admin.dashboard') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-3 border-0 {{ request()->routeIs('admin.dashboard') ? 'active bg-danger text-white fw-bold' : 'text-dark' }}">
                    <i class="bi bi-speedometer2 fs-5"></i>
                    <span>Admin Dashboard</span>
                </a>

                <div class="px-3 pt-3 pb-1 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    Management CRUD
                </div>

                <!-- TV Shows CRUD -->
                <a href="{{ route('admin.tv-shows.index') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 px-3 border-0 {{ request()->routeIs('admin.tv-shows.*') ? 'active bg-danger text-white fw-bold' : 'text-dark' }}">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-film fs-5"></i>
                        <span>TV Shows</span>
                    </div>
                    <span class="badge {{ request()->routeIs('admin.tv-shows.*') ? 'text-bg-light border text-dark' : 'text-bg-secondary' }} rounded-pill">CRUD</span>
                </a>
                @if(request()->routeIs('admin.tv-shows.*'))
                    <div class="ps-4 pe-2 py-1 bg-light border-start border-danger border-3">
                        <a href="{{ route('admin.tv-shows.create') }}" class="btn btn-sm btn-outline-danger w-100 text-start fw-semibold mb-1">
                            <i class="bi bi-plus-circle me-1"></i>New TV Show
                        </a>
                    </div>
                @endif

                <!-- Episodes CRUD -->
                <a href="{{ route('admin.episodes.index') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 px-3 border-0 {{ request()->routeIs('admin.episodes.*') ? 'active bg-danger text-white fw-bold' : 'text-dark' }}">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-collection-play fs-5"></i>
                        <span>Episodes</span>
                    </div>
                    <span class="badge {{ request()->routeIs('admin.episodes.*') ? 'text-bg-light border text-dark' : 'text-bg-secondary' }} rounded-pill">CRUD</span>
                </a>
                @if(request()->routeIs('admin.episodes.*'))
                    <div class="ps-4 pe-2 py-1 bg-light border-start border-danger border-3">
                        <a href="{{ route('admin.episodes.create') }}" class="btn btn-sm btn-outline-danger w-100 text-start fw-semibold mb-1">
                            <i class="bi bi-plus-circle me-1"></i>New Episode
                        </a>
                    </div>
                @endif

                <!-- Users (Read-Only) -->
                <a href="{{ route('admin.users.index') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 px-3 border-0 {{ request()->routeIs('admin.users.*') ? 'active bg-danger text-white fw-bold' : 'text-dark' }}">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-people fs-5"></i>
                        <span>Users</span>
                    </div>
                    <span class="badge text-bg-secondary rounded-pill">Read Only</span>
                </a>

                <div class="px-3 pt-3 pb-1 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    Public Site
                </div>

                <a href="{{ route('home') }}"
                   class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-3 border-0 text-muted">
                    <i class="bi bi-box-arrow-left fs-5"></i>
                    <span>Back to Main Site</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Admin Content Area -->
    <div class="col-lg-9 col-md-8">
        @yield('admin_content')
    </div>
</div>
@endsection

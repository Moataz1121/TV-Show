@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-danger text-white py-3">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-shield-lock me-2"></i>SHOW.TV Admin Area
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="user-avatar-lg border shadow-sm">
                    <div>
                        <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                        <span class="badge text-bg-danger text-uppercase px-3 py-2">
                            <i class="bi bi-person-badge me-1"></i>Administrator Access
                        </span>
                    </div>
                </div>

                <hr>

                <div class="row g-4 mt-1">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-danger text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-people fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">Users Management</h5>
                                        <small class="text-muted">Read-only view of registered users</small>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-dark w-100 fw-semibold">
                                    View Registered Users &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-danger text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-film fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">TV Shows CRUD</h5>
                                        <small class="text-muted">List, Create, View, and Edit TV series</small>
                                    </div>
                                </div>
                                <a href="{{ route('admin.tv-shows.index') }}" class="btn btn-danger w-100 fw-semibold">
                                    Manage TV Shows &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

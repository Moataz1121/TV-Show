@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 rounded-3">
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

                <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">Admin Authorization Active</h6>
                        <small>You are authenticated as an administrator. Future Admin CRUD sections (Users, TV Shows, Episodes) will be accessible from this area.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

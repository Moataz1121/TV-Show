@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2"></i>User Profile & Dashboard</h4>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4 mb-4">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="user-avatar-lg border shadow-sm">
                    <div>
                        <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-muted mb-2"><i class="bi bi-envelope me-1"></i>{{ Auth::user()->email }}</p>
                        <span class="badge text-bg-success text-uppercase fs-6">Role: {{ Auth::user()->role }}</span>
                    </div>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="text-muted mb-1">Account Created</h6>
                            <p class="fw-semibold mb-0">{{ Auth::user()->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="text-muted mb-1">Media Profile Image Status</h6>
                            <p class="fw-semibold mb-0">
                                @if(Auth::user()->hasMedia('avatar'))
                                    <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Uploaded via Spatie Media Library</span>
                                @else
                                    <span class="text-secondary"><i class="bi bi-info-circle me-1"></i>Default UI-Avatar Placeholder</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

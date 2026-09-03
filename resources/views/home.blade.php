@extends('layouts.app')

@section('title', 'Welcome to SHOW.TV')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="p-5 mb-4 bg-dark text-white rounded-3 shadow">
            <div class="container-fluid py-3">
                <h1 class="display-4 fw-bold text-danger">Welcome to SHOW.TV</h1>
                <p class="col-md-10 fs-5 text-light">
                    Your premier platform for discovering TV series, watching episodes, following your favorite shows, and sharing reactions.
                </p>
                @guest
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-danger btn-lg me-2 fw-semibold">Get Started</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg fw-semibold">Login</a>
                    </div>
                @else
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                        </a>
                    </div>
                @endguest
            </div>
        </div>

        @auth
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="user-avatar-lg border shadow-sm">
                    <div>
                        <h4 class="mb-1 fw-bold">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                        <span class="badge text-bg-primary text-uppercase">{{ Auth::user()->role }} Account</span>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>
</div>
@endsection

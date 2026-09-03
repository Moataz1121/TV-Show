@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-box-arrow-in-right me-2"></i>Login to SHOW.TV</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">Remember Me</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-lg fw-semibold">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <span class="text-muted">Don't have an account?</span>
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none ms-1">Register here</a>
            </div>
        </div>
    </div>
</div>
@endsection

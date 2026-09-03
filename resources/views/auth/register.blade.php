@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2"></i>Create SHOW.TV Account</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimum 8 characters">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter password">
                    </div>

                    <!-- Profile Image (Spatie Media Library) -->
                    <div class="mb-4">
                        <label for="avatar" class="form-label fw-semibold">Profile Image (Optional)</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2 text-center d-none" id="avatarPreviewContainer">
                            <small class="text-muted d-block mb-1">Image Preview:</small>
                            <img id="avatarPreview" src="#" alt="Avatar Preview" class="user-avatar-lg border shadow-sm">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">Register Account</button>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <span class="text-muted">Already have an account?</span>
                <a href="{{ route('login') }}" class="fw-bold text-decoration-none ms-1">Login here</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // jQuery image preview feature
        $('#avatar').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').attr('src', e.target.result);
                    $('#avatarPreviewContainer').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                $('#avatarPreviewContainer').addClass('d-none');
            }
        });
    });
</script>
@endpush

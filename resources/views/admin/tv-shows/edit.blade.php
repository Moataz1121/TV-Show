@extends('layouts.app')

@section('title', 'Admin - Edit TV Show: ' . $tvShow->title)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tv-shows.index') }}">TV Shows</a></li>
        <li class="breadcrumb-item active">Edit #{{ $tvShow->id }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-dark text-white py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit TV Show</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.tv-shows.update', $tvShow) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title English -->
                    <div class="mb-3">
                        <label for="title_en" class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title.en') is-invalid @enderror" id="title_en" name="title[en]" value="{{ old('title.en', $tvShow->getTranslation('title', 'en', false)) }}" required placeholder="e.g. Breaking Bad">
                        @error('title.en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title Arabic -->
                    <div class="mb-3">
                        <label for="title_ar" class="form-label fw-semibold">Title (Arabic)</label>
                        <input type="text" class="form-control @error('title.ar') is-invalid @enderror" id="title_ar" name="title[ar]" value="{{ old('title.ar', $tvShow->getTranslation('title', 'ar', false)) }}" placeholder="مثال: بريكينج باد" dir="rtl">
                        @error('title.ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description English -->
                    <div class="mb-3">
                        <label for="description_en" class="form-label fw-semibold">Description (English) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description.en') is-invalid @enderror" id="description_en" name="description[en]" rows="4" required placeholder="Enter English description...">{{ old('description.en', $tvShow->getTranslation('description', 'en', false)) }}</textarea>
                        @error('description.en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Arabic -->
                    <div class="mb-3">
                        <label for="description_ar" class="form-label fw-semibold">Description (Arabic)</label>
                        <textarea class="form-control @error('description.ar') is-invalid @enderror" id="description_ar" name="description[ar]" rows="4" placeholder="أدخل الوصف باللغة العربية..." dir="rtl">{{ old('description.ar', $tvShow->getTranslation('description', 'ar', false)) }}</textarea>
                        @error('description.ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Airing Time -->
                    <div class="mb-4">
                        <label for="airing_time" class="form-label fw-semibold">Airing Time</label>
                        <input type="datetime-local" class="form-control @error('airing_time') is-invalid @enderror" id="airing_time" name="airing_time" value="{{ old('airing_time', $tvShow->airing_time ? $tvShow->airing_time->format('Y-m-d\TH:i') : '') }}">
                        @error('airing_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('admin.tv-shows.show', $tvShow) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary fw-semibold px-4">Update TV Show</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Admin - Edit Episode')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.episodes.index') }}">Episodes</a></li>
        <li class="breadcrumb-item active">Edit Episode</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Episode #{{ $episode->id }}</h5>
                <a href="{{ route('admin.episodes.show', $episode) }}" class="btn btn-outline-light btn-sm">
                    &larr; View Details
                </a>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.episodes.update', $episode) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Select TV Show -->
                    <div class="mb-4">
                        <label for="tv_show_id" class="form-label fw-bold">Related TV Show <span class="text-danger">*</span></label>
                        <select name="tv_show_id" id="tv_show_id" class="form-select @error('tv_show_id') is-invalid @enderror" required>
                            @foreach($shows as $show)
                                <option value="{{ $show->id }}" {{ old('tv_show_id', $episode->tv_show_id) == $show->id ? 'selected' : '' }}>
                                    {{ $show->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('tv_show_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Spatie Translatable Title & Description (Language Tabs) -->
                    <ul class="nav nav-tabs mb-3" id="translatableTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab">
                                🇬🇧 English
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar-content" type="button" role="tab">
                                🇸🇦 Arabic (العربية)
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mb-4" id="translatableTabsContent">
                        <!-- English Form Fields -->
                        <div class="tab-pane fade show active" id="en-content" role="tabpanel">
                            <div class="mb-3">
                                <label for="title_en" class="form-label fw-bold">English Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="title[en]"
                                       id="title_en"
                                       class="form-control @error('title.en') is-invalid @enderror"
                                       value="{{ old('title.en', $episode->getTranslation('title', 'en', false)) }}"
                                       required>
                                @error('title.en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description_en" class="form-label fw-bold">English Description <span class="text-danger">*</span></label>
                                <textarea name="description[en]"
                                          id="description_en"
                                          rows="4"
                                          class="form-control @error('description.en') is-invalid @enderror"
                                          required>{{ old('description.en', $episode->getTranslation('description', 'en', false)) }}</textarea>
                                @error('description.en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Arabic Form Fields -->
                        <div class="tab-pane fade" id="ar-content" role="tabpanel">
                            <div class="mb-3">
                                <label for="title_ar" class="form-label fw-bold">Arabic Title (العنوان بالعربية)</label>
                                <input type="text"
                                       name="title[ar]"
                                       id="title_ar"
                                       dir="rtl"
                                       class="form-control @error('title.ar') is-invalid @enderror"
                                       value="{{ old('title.ar', $episode->getTranslation('title', 'ar', false)) }}">
                                @error('title.ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description_ar" class="form-label fw-bold">Arabic Description (الوصف بالعربية)</label>
                                <textarea name="description[ar]"
                                          id="description_ar"
                                          rows="4"
                                          dir="rtl"
                                          class="form-control @error('description.ar') is-invalid @enderror">{{ old('description.ar', $episode->getTranslation('description', 'ar', false)) }}</textarea>
                                @error('description.ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Duration -->
                        <div class="col-md-6">
                            <label for="duration" class="form-label fw-bold">Duration (Minutes) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number"
                                       name="duration"
                                       id="duration"
                                       class="form-control @error('duration') is-invalid @enderror"
                                       value="{{ old('duration', $episode->duration) }}"
                                       min="1"
                                       required>
                                <span class="input-group-text">mins</span>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Airing Time -->
                        <div class="col-md-6">
                            <label for="airing_time" class="form-label fw-bold">Airing Date & Time</label>
                            <input type="datetime-local"
                                   name="airing_time"
                                   id="airing_time"
                                   class="form-control @error('airing_time') is-invalid @enderror"
                                   value="{{ old('airing_time', $episode->airing_time ? $episode->airing_time->format('Y-m-d\TH:i') : '') }}">
                            @error('airing_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Thumbnail Media -->
                    <div class="card bg-light border-0 mb-4 p-3 rounded-3">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-image me-1 text-danger"></i>Thumbnail Image</h6>
                        @if($episode->thumbnail)
                            <div class="mb-3 d-flex align-items-center gap-3">
                                <img src="{{ $episode->thumbnail }}" alt="{{ $episode->title }}" class="rounded border shadow-sm" style="max-height: 80px;">
                                <small class="text-muted d-block">Current Thumbnail URL:<br><code>{{ $episode->thumbnail }}</code></small>
                            </div>
                        @endif
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="thumbnail" class="form-label small fw-semibold">Replace with Uploaded Image</label>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="thumbnail_url" class="form-label small fw-semibold">OR Replace with Image URL</label>
                                <input type="url" name="thumbnail_url" id="thumbnail_url" class="form-control @error('thumbnail_url') is-invalid @enderror" value="{{ old('thumbnail_url') }}" placeholder="https://example.com/poster.jpg">
                                @error('thumbnail_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Video Media -->
                    <div class="card bg-light border-0 mb-4 p-3 rounded-3">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-camera-video me-1 text-danger"></i>Video Stream File / URL</h6>
                        @if($episode->video)
                            <div class="mb-3">
                                <small class="text-muted d-block">Current Video Location:<br><code>{{ $episode->video }}</code></small>
                            </div>
                        @endif
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="video" class="form-label small fw-semibold">Replace with Uploaded Video</label>
                                <input type="file" name="video" id="video" class="form-control @error('video') is-invalid @enderror" accept="video/*">
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="video_url" class="form-label small fw-semibold">OR Replace with Video URL</label>
                                <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://example.com/stream.mp4">
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.episodes.show', $episode) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="bi bi-check-lg me-1"></i>Update Episode
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

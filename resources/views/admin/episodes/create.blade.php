@extends('layouts.app')

@section('title', 'Admin - Create Episode')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.episodes.index') }}">Episodes</a></li>
        <li class="breadcrumb-item active">Create Episode</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2 text-danger"></i>Create New Episode</h5>
                <a href="{{ route('admin.episodes.index') }}" class="btn btn-outline-light btn-sm">
                    &larr; Back to Episodes
                </a>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.episodes.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Select TV Show -->
                    <div class="mb-4">
                        <label for="tv_show_id" class="form-label fw-bold">Related TV Show <span class="text-danger">*</span></label>
                        <select name="tv_show_id" id="tv_show_id" class="form-select @error('tv_show_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('tv_show_id') ? '' : 'selected' }}>Select a TV Show...</option>
                            @foreach($shows as $show)
                                <option value="{{ $show->id }}" {{ old('tv_show_id') == $show->id ? 'selected' : '' }}>
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
                                🇬🇧 English (Default)
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
                                       value="{{ old('title.en') }}"
                                       placeholder="Enter English episode title..."
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
                                          placeholder="Enter English episode description..."
                                          required>{{ old('description.en') }}</textarea>
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
                                       value="{{ old('title.ar') }}"
                                       placeholder="أدخل عنوان الحلقة بالعربية...">
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
                                          class="form-control @error('description.ar') is-invalid @enderror"
                                          placeholder="أدخل وصف الحلقة بالعربية...">{{ old('description.ar') }}</textarea>
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
                                       value="{{ old('duration', 45) }}"
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
                                   value="{{ old('airing_time') }}">
                            @error('airing_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Thumbnail Media -->
                    <div class="card bg-light border-0 mb-4 p-3 rounded-3">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-image me-1 text-danger"></i>Thumbnail Image</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="thumbnail" class="form-label small fw-semibold">Upload Image File</label>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="thumbnail_url" class="form-label small fw-semibold">OR Image URL String</label>
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
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="video" class="form-label small fw-semibold">Upload Video File</label>
                                <input type="file" name="video" id="video" class="form-control @error('video') is-invalid @enderror" accept="video/*">
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="video_url" class="form-label small fw-semibold">OR Video URL Stream</label>
                                <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://example.com/stream.mp4">
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.episodes.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-danger px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i>Create Episode
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

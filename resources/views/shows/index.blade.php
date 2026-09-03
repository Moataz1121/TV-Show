@extends('layouts.app')

@section('title', 'TV Shows')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-film me-2 text-danger"></i>Explore TV Shows</h2>
        <p class="text-muted mb-0">Browse our collection of series and episodes.</p>
    </div>
</div>

@if($shows->isEmpty())
    <div class="alert alert-info py-4 text-center">
        <i class="bi bi-film fs-3 d-block mb-2"></i>
        No TV shows available at the moment.
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
        @foreach($shows as $show)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="card-title fw-bold text-dark mb-0">{{ $show->title }}</h4>
                            <span class="badge text-bg-danger rounded-pill px-3 py-2">
                                <i class="bi bi-collection-play me-1"></i>{{ $show->episodes_count }} Episodes
                            </span>
                        </div>
                        <p class="card-text text-muted small my-3 flex-grow-1">
                            {{ Str::limit($show->description, 140) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                Airs: {{ $show->airing_time ? $show->airing_time->format('M d, Y') : 'TBA' }}
                            </small>
                            <a href="{{ route('shows.show', $show) }}" class="btn btn-dark btn-sm px-3 fw-semibold">
                                View Episodes &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $shows->links() }}
    </div>
@endif
@endsection

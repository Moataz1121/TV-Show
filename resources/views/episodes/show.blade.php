@extends('layouts.app')

@section('title', $episode->title . ' - ' . $episode->tvShow->title)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shows.index') }}">TV Shows</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shows.show', $episode->tvShow) }}">{{ $episode->tvShow->title }}</a></li>
        <li class="breadcrumb-item active">{{ $episode->title }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Video Player Section -->
        <div class="card shadow-lg border-0 rounded-3 overflow-hidden mb-4 bg-black">
            <div class="ratio ratio-16x9">
                @if(!$episode->isAired())
                    <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark p-4">
                        <i class="bi bi-calendar-event fs-1 mb-3 text-warning"></i>
                        <h5 class="fw-bold text-warning mb-1">Upcoming Episode</h5>
                        <p class="text-white-50 small mb-0">Scheduled Airing Time: <strong>{{ $episode->airing_time ? $episode->airing_time->format('M d, Y \a\t H:i') : 'TBA' }}</strong></p>
                        <small class="text-white-50 mt-1">Video stream will become available when the episode airs.</small>
                    </div>
                @elseif($episode->video)
                    <video controls poster="{{ $episode->thumbnail }}" class="w-100 h-100">
                        <source src="{{ $episode->video }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark">
                        <i class="bi bi-film fs-1 mb-3 text-danger"></i>
                        <h5 class="fw-bold">Episode Video Player</h5>
                        <p class="text-white-50 small mb-0">Video stream placeholder for {{ $episode->title }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Episode Details & Reactions Section -->
        <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3 border-bottom pb-3">
                <div>
                    <span class="badge text-bg-danger text-uppercase mb-2 px-3 py-2">
                        <i class="bi bi-tv me-1"></i>{{ $episode->tvShow->title }}
                    </span>
                    @if(!$episode->isAired())
                        <span class="badge text-bg-warning text-uppercase mb-2 px-3 py-2 ms-1">
                            <i class="bi bi-clock me-1"></i>Upcoming
                        </span>
                    @endif
                    <h2 class="fw-bold text-dark mb-1">{{ $episode->title }}</h2>
                </div>

                <!-- Reactions Action Buttons (jQuery AJAX Handled) -->
                <div class="d-flex align-items-center gap-2">
                    @if(!$episode->isAired())
                        <span class="badge text-bg-warning py-2 px-3">
                            <i class="bi bi-lock me-1"></i>Reactions unlock on airing
                        </span>
                    @else
                        <!-- Like Form -->
                        <form method="POST" action="{{ route('episodes.react', $episode) }}" class="reaction-form">
                            @csrf
                            <input type="hidden" name="type" value="like">
                            <button type="submit"
                                    id="like-btn"
                                    class="btn reaction-btn {{ $userReaction === 'like' ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center gap-2 fw-semibold px-3">
                                <i class="bi {{ $userReaction === 'like' ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i>
                                <span>Like</span>
                                <span id="like-count" class="badge text-bg-light border text-dark ms-1">{{ $reactionCounts['likes'] }}</span>
                            </button>
                        </form>

                        <!-- Dislike Form -->
                        <form method="POST" action="{{ route('episodes.react', $episode) }}" class="reaction-form">
                            @csrf
                            <input type="hidden" name="type" value="dislike">
                            <button type="submit"
                                    id="dislike-btn"
                                    class="btn reaction-btn {{ $userReaction === 'dislike' ? 'btn-danger' : 'btn-outline-danger' }} d-flex align-items-center gap-2 fw-semibold px-3">
                                <i class="bi {{ $userReaction === 'dislike' ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-down' }}"></i>
                                <span>Dislike</span>
                                <span id="dislike-count" class="badge text-bg-light border text-dark ms-1">{{ $reactionCounts['dislikes'] }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row text-muted mb-3 fs-6">
                <div class="col-md-6 mb-2 mb-md-0">
                    <i class="bi bi-clock text-danger me-1"></i>
                    <strong>Duration:</strong> {{ $episode->duration ? $episode->duration . ' minutes' : 'N/A' }}
                </div>
                <div class="col-md-6">
                    <i class="bi bi-calendar-event text-danger me-1"></i>
                    <strong>Airing Time:</strong> {{ $episode->airing_time ? $episode->airing_time->format('M d, Y H:i') : 'TBA' }}
                </div>
            </div>

            <div class="mb-4 pt-2">
                <h5 class="fw-bold text-dark mb-2">Overview</h5>
                <p class="text-secondary fs-6 lead">{{ $episode->description }}</p>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="{{ route('shows.show', $episode->tvShow) }}" class="btn btn-outline-secondary btn-sm">
                    &larr; Back to {{ $episode->tvShow->title }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.reaction-form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const actionUrl = form.attr('action');
        const reactionType = form.find('input[name="type"]').val();
        const csrfToken = form.find('input[name="_token"]').val();

        $('.reaction-btn').prop('disabled', true);

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: {
                _token: csrfToken,
                type: reactionType
            },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    // Update reaction count badges
                    $('#like-count').text(response.likesCount);
                    $('#dislike-count').text(response.dislikesCount);

                    const likeBtn = $('#like-btn');
                    const likeIcon = likeBtn.find('i');
                    const dislikeBtn = $('#dislike-btn');
                    const dislikeIcon = dislikeBtn.find('i');

                    // Reset styles to default non-active state
                    likeBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                    likeIcon.removeClass('bi-hand-thumbs-up-fill').addClass('bi-hand-thumbs-up');

                    dislikeBtn.removeClass('btn-danger').addClass('btn-outline-danger');
                    dislikeIcon.removeClass('bi-hand-thumbs-down-fill').addClass('bi-hand-thumbs-down');

                    // Update active button styles according to user reaction state
                    if (response.userReaction === 'like') {
                        likeBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                        likeIcon.removeClass('bi-hand-thumbs-up').addClass('bi-hand-thumbs-up-fill');
                    } else if (response.userReaction === 'dislike') {
                        dislikeBtn.removeClass('btn-outline-danger').addClass('btn-danger');
                        dislikeIcon.removeClass('bi-hand-thumbs-down').addClass('bi-hand-thumbs-down-fill');
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = "{{ route('login') }}";
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                } else {
                    console.error('Reaction error:', xhr);
                }
            },
            complete: function() {
                $('.reaction-btn').prop('disabled', false);
            }
        });
    });
});
</script>
@endpush

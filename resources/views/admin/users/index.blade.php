@extends('layouts.app')

@section('title', 'Admin - Manage Users')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-people me-2 text-danger"></i>User Management</h2>
        <p class="text-muted mb-0">Read-only listing of all registered users on SHOW.TV.</p>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="ps-4">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Followed Shows</th>
                        <th scope="col">Registered</th>
                        <th scope="col" class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-nav border">
                                    <span class="fw-bold text-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge text-bg-danger text-uppercase px-2 py-1">Admin</span>
                                @else
                                    <span class="badge text-bg-secondary text-uppercase px-2 py-1">User</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge text-bg-light border text-dark">
                                    <i class="bi bi-heart-fill text-danger me-1"></i>{{ $user->tv_shows_count }} Shows
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-dark btn-sm fw-semibold">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No users registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
        <div class="card-footer bg-light d-flex justify-content-center py-3">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection

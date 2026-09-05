<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(): View
    {
        $users = $this->userService->getPaginatedUsers(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $userDetails = $this->userService->getUserDetails($user->id) ?? $user;

        return view('admin.users.show', ['user' => $userDetails]);
    }
}

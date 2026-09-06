<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $this->authService->login(
            $request->only('email', 'password'),
            $request->boolean('remember'),
            $request
        );

        if (auth()->user()?->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Logged in as Admin! Welcome to SHOW.TV Admin Panel.');
        }

        return redirect()->intended(route('home'))->with('success', 'Logged in successfully!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout($request);

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

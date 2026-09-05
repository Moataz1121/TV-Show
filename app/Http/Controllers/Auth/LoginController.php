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
        Log::info('[LoginController] Displaying login form page.');

        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        Log::info('[LoginController] Login request received.', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'remember' => $request->boolean('remember'),
        ]);

        $this->authService->login(
            $request->only('email', 'password'),
            $request->boolean('remember'),
            $request
        );

        Log::info('[LoginController] Login successful, redirecting user.', [
            'user_id' => auth()->id(),
            'email' => auth()->user()?->email,
            'role' => auth()->user()?->role,
        ]);

        return redirect()->intended(route('home'))->with('success', 'Logged in successfully!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Log::info('[LoginController] Logout request received.', [
            'user_id' => auth()->id(),
            'email' => auth()->user()?->email,
        ]);

        $this->authService->logout($request);

        Log::info('[LoginController] User logged out successfully.');

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

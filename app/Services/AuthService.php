<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new user and log them in.
     */
    public function register(array $data, ?UploadedFile $avatar = null): User
    {
        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user',
        ]);

        if ($avatar) {
            $this->userRepository->updateAvatar($user, $avatar);
        }

        Auth::login($user);

        return $user;
    }

    /**
     * Authenticate user credentials and create session.
     */
    public function login(array $credentials, bool $remember = false, ?Request $request = null): bool
    {
        if (Auth::attempt($credentials, $remember)) {
            if ($request) {
                $request->session()->regenerate();
            }
            return true;
        }

        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }

    /**
     * Logout the current user and invalidate session.
     */
    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}

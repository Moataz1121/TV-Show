<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        Log::info('[AuthService] Registering new user.', ['email' => $data['email'], 'name' => $data['name']]);

        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user',
        ]);

        if ($avatar) {
            Log::info('[AuthService] Attaching avatar to new user.', ['user_id' => $user->id]);
            $this->userRepository->updateAvatar($user, $avatar);
        }

        Auth::login($user);

        Log::info('[AuthService] User registered and logged in successfully.', ['user_id' => $user->id]);

        return $user;
    }

    /**
     * Authenticate user credentials and create session.
     */
    public function login(array $credentials, bool $remember = false, ?Request $request = null): bool
    {
        $email = $credentials['email'] ?? null;
        Log::info('[AuthService] STEP 1: Checking user existence in database.', ['email' => $email]);

        $user = $this->userRepository->findByEmail($email);

        if (! $user) {
            Log::warning('[AuthService] STEP 1 FAILED: User not found in database.', ['email' => $email]);
        } else {
            Log::info('[AuthService] STEP 1 PASSED: User record found in database.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ]);
        }

        Log::info('[AuthService] STEP 2: Attempting password verification via Auth::attempt().');

        if (Auth::attempt($credentials, $remember)) {
            Log::info('[AuthService] STEP 2 PASSED: Credentials matched & user authenticated successfully.', [
                'user_id' => Auth::id(),
                'role' => Auth::user()?->role,
            ]);

            if ($request) {
                $request->session()->regenerate();
                Log::info('[AuthService] STEP 3: Session ID regenerated.', [
                    'session_id' => $request->session()->getId(),
                ]);
            }

            return true;
        }

        Log::warning('[AuthService] STEP 2 FAILED: Auth::attempt() returned false (Password mismatch or authentication rejected).', [
            'email' => $email,
        ]);

        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }

    /**
     * Logout the current user and invalidate session.
     */
    public function logout(Request $request): void
    {
        $userId = Auth::id();
        Log::info('[AuthService] Logging out user.', ['user_id' => $userId]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('[AuthService] User session invalidated and CSRF token regenerated.', ['former_user_id' => $userId]);
    }
}

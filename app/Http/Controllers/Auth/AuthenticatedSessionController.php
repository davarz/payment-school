<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // Authenticate user
            $request->authenticate();

            $request->session()->regenerate();

            $user = Auth::user();
            
            // Validasi user dan role
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => 'Autentikasi gagal.',
                ]);
            }

            // Redirect berdasarkan role dengan validasi
            if (empty($user->role)) {
                Log::warning('User logged in without role', ['user_id' => $user->id]);
                return redirect()->route('dashboard');
            }

            // Redirect berdasarkan role
            return match(strtolower($user->role)) {
                'admin' => $this->safeRedirect('admin.dashboard'),
                'operator' => $this->safeRedirect('operator.dashboard'),
                'siswa' => $this->safeRedirect('siswa.dashboard'),
                default => redirect()->route('dashboard'),
            };

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Login error', ['error' => $e->getMessage()]);
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        } catch (\Exception $e) {
            Log::error('Logout error', ['error' => $e->getMessage()]);
            return redirect('/');
        }
    }

    /**
     * Safe redirect dengan pengecekan route
     */
    private function safeRedirect(string $routeName): RedirectResponse
    {
        try {
            if (Route::has($routeName)) {
                return redirect()->route($routeName);
            }
            
            Log::warning("Route {$routeName} tidak ditemukan di AuthenticatedSessionController");
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            Log::error("Error redirecting to {$routeName}", ['error' => $e->getMessage()]);
            return redirect()->route('dashboard');
        }
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Default guard jika tidak ada yang spesifik
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Log untuk debugging (hapus di production)
                Log::info('RedirectIfAuthenticated triggered', [
                    'user_id' => $user->id,
                    'user_role' => $user->role ?? 'none',
                    'guard' => $guard
                ]);

                // Redirect berdasarkan role dengan validasi
                try {
                    if (empty($user->role)) {
                        Log::warning('User without role detected', ['user_id' => $user->id]);
                        return redirect('/'); // Redirect ke home jika role kosong
                    }

                    // Gunakan match expression untuk PHP 8.0+
                    return match(strtolower($user->role)) {
                        'admin' => $this->safeRedirect('admin.dashboard'),
                        'operator' => $this->safeRedirect('operator.dashboard'),
                        'siswa' => $this->safeRedirect('siswa.dashboard'),
                        default => redirect('/'), // Default ke home
                    };
                } catch (\Exception $e) {
                    Log::error('Error in RedirectIfAuthenticated', [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id
                    ]);
                    return redirect('/'); // Fallback ke home jika error
                }
            }
        }

        return $next($request);
    }

    /**
     * Safe redirect dengan pengecekan route exists
     */
    private function safeRedirect(string $routeName)
    {
        try {
            // Cek apakah route ada sebelum redirect
            if (\Illuminate\Support\Facades\Route::has($routeName)) {
                return redirect()->route($routeName);
            }
            
            Log::warning("Route {$routeName} tidak ditemukan");
            return redirect('/'); // Fallback ke home
        } catch (\Exception $e) {
            Log::error("Error redirecting to {$routeName}", ['error' => $e->getMessage()]);
            return redirect('/');
        }
    }
}
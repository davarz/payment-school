<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Debug info
        Log::info('CheckRole middleware executed', [
            'path' => $request->path(),
            'required_roles' => $roles,
            'user_role' => auth()->user()->role ?? 'guest'
        ]);

        // Cek apakah user sudah login
        if (!auth()->check()) {
            Log::warning('Unauthenticated access attempt', ['path' => $request->path()]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        // Cek apakah user memiliki role yang valid
        if (empty($user->role)) {
            Log::error('User without role accessing protected route', [
                'user_id' => $user->id,
                'path' => $request->path()
            ]);
            
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda bermasalah. Silakan hubungi administrator.');
        }

        // Cek apakah user memiliki salah satu role yang diizinkan
        $hasAccess = false;
        foreach ($roles as $role) {
            if (strtolower($user->role) === strtolower($role)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            Log::warning('Unauthorized access attempt', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'required_roles' => $roles,
                'path' => $request->path()
            ]);

            // Redirect berdasarkan role user
            return match(strtolower($user->role)) {
                'admin' => redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'operator' => redirect()->route('operator.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'siswa' => redirect()->route('siswa.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                default => redirect()->route('dashboard')
                    ->with('error', 'Akses ditolak.'),
            };
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'operator' && !$user->isOperator()) {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'siswa' && !$user->isSiswa()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
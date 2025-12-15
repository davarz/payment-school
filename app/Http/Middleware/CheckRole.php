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
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        // Cek role berdasarkan method yang ada di User model
        switch ($role) {
            case 'admin':
                if (!$user->isAdmin()) {
                    return $this->redirectBasedOnRole($user);
                }
                break;
                
            case 'operator':
                if (!$user->isOperator()) {
                    return $this->redirectBasedOnRole($user);
                }
                break;
                
            case 'siswa':
                if (!$user->isSiswa()) {
                    return $this->redirectBasedOnRole($user);
                }
                break;
                
            default:
                // Support untuk multiple roles (admin,operator)
                $roles = explode(',', $role);
                $hasRole = false;
                
                foreach ($roles as $r) {
                    $r = trim($r);
                    if (($r === 'admin' && $user->isAdmin()) ||
                        ($r === 'operator' && $user->isOperator()) ||
                        ($r === 'siswa' && $user->isSiswa())) {
                        $hasRole = true;
                        break;
                    }
                }
                
                if (!$hasRole) {
                    return $this->redirectBasedOnRole($user);
                }
                break;
        }

        return $next($request);
    }

    /**
     * Redirect user berdasarkan role mereka
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                    
            case 'operator':
                return redirect()->route('operator.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                    
            case 'siswa':
                return redirect()->route('siswa.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                    
            default:
                abort(403, 'Unauthorized action.');
        }
    }
}
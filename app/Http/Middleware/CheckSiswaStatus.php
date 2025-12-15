<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Siswa;

class CheckSiswaStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Hanya berlaku untuk siswa
        if ($user && $user->role === 'siswa') {
            // Cek status siswa di tabel siswa
            $siswa = Siswa::where('user_id', $user->id)->first();
            
            if (!$siswa) {
                // Jika data siswa belum ada
                if ($request->route()->getName() !== 'siswa.profile.edit') {
                    return redirect()->route('siswa.profile.edit')
                        ->with('warning', 'Silakan lengkapi data siswa terlebih dahulu.');
                }
            } elseif ($siswa->status_siswa !== 'aktif') {
                // Jika siswa tidak aktif
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }
        }

        return $next($request);
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PasswordResetService
{
    /**
     * Check IP rate limit
     */
    public function checkIpRateLimit(string $ip): bool
    {
        $key = 'pwd_reset_ip:' . $ip;
        $attempts = Cache::get($key, 0);
        
        return $attempts >= 5; // Max 5 attempts per IP per hour
    }

    /**
     * Check email rate limit
     */
    public function checkEmailRateLimit(string $email): bool
    {
        $key = 'password_reset_attempts:' . $email;
        $attempts = Cache::get($key, 0);
        
        return $attempts >= 3; // Max 3 attempts per email per hour
    }

    /**
     * Validate user
     */
    public function validateUser(string $email): array
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return [
                'success' => false,
                'error' => 'Email tidak terdaftar di sistem'
            ];
        }

        // Cek jika user adalah siswa dan tidak aktif
        if ($user->role === 'siswa') {
            $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
            if (!$siswa || $siswa->status_siswa !== 'aktif') {
                return [
                    'success' => false,
                    'error' => 'Akun siswa tidak aktif. Silakan hubungi administrator.'
                ];
            }
        }

        return ['success' => true];
    }

    /**
     * Delete existing tokens
     */
    public function deleteExistingTokens(string $email): int
    {
        return DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }

    /**
     * Increment rate limit counters
     */
    public function incrementRateLimit(string $ip, string $email): void
    {
        // IP rate limit
        $ipKey = 'pwd_reset_ip:' . $ip;
        Cache::put($ipKey, Cache::get($ipKey, 0) + 1, now()->addHour());

        // Email rate limit
        $emailKey = 'password_reset_attempts:' . $email;
        Cache::put($emailKey, Cache::get($emailKey, 0) + 1, now()->addHour());
    }

    /**
     * Clear reset cache
     */
    public function clearResetCache(string $email, string $ip): void
    {
        Cache::forget('pwd_reset_ip:' . $ip);
        Cache::forget('password_reset_attempts:' . $email);
    }
}
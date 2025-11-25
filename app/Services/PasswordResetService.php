<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class PasswordResetService
{
    const MAX_ATTEMPTS_PER_IP = 5;
    const MAX_ATTEMPTS_PER_EMAIL = 3;
    const RATE_LIMIT_DURATION = 3600; // 1 jam dalam detik
    const TOKEN_EXPIRY_MINUTES = 60;

    /**
     * Cek apakah IP sudah melebihi rate limit
     */
    public function checkIpRateLimit(string $ip): bool
    {
        $key = "pwd_reset_ip:{$ip}";
        $attempts = Cache::get($key, 0);
        
        return $attempts >= self::MAX_ATTEMPTS_PER_IP;
    }

    /**
     * Cek apakah email sudah melebihi rate limit
     */
    public function checkEmailRateLimit(string $email): bool
    {
        $key = "pwd_reset_email:{$email}";
        $attempts = Cache::get($key, 0);
        
        return $attempts >= self::MAX_ATTEMPTS_PER_EMAIL;
    }

    /**
     * Increment rate limit counter
     */
    public function incrementRateLimit(string $ip, string $email): void
    {
        $ipKey = "pwd_reset_ip:{$ip}";
        $emailKey = "pwd_reset_email:{$email}";
        
        Cache::put($ipKey, Cache::get($ipKey, 0) + 1, self::RATE_LIMIT_DURATION);
        Cache::put($emailKey, Cache::get($emailKey, 0) + 1, self::RATE_LIMIT_DURATION);
    }

    /**
     * Validasi user apakah boleh reset password
     */
    public function validateUser(string $email): array
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return [
                'success' => false,
                'error' => 'Email tidak terdaftar dalam sistem.'
            ];
        }

        if ($user->role !== 'siswa') {
            Log::warning('Non-siswa attempted password reset', [
                'email' => $email,
                'role' => $user->role
            ]);

            return [
                'success' => false,
                'error' => 'Hanya siswa yang dapat reset password melalui sistem ini. Admin/Operator silakan hubungi super admin.'
            ];
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }

    /**
     * Delete existing tokens untuk email tertentu
     */
    public function deleteExistingTokens(string $email): int
    {
        $count = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->count();

        if ($count > 0) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            Log::info('Deleted existing password reset tokens', [
                'email' => $email,
                'count' => $count
            ]);
        }

        return $count;
    }

    /**
     * Kirim reset link
     */
    public function sendResetLink(string $email): array
    {
        try {
            $status = Password::sendResetLink(['email' => $email]);

            if ($status === Password::RESET_LINK_SENT) {
                Log::info('Password reset link sent successfully', [
                    'email' => $email,
                    'timestamp' => now()
                ]);

                return [
                    'success' => true,
                    'message' => 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.'
                ];
            }

            Log::warning('Password reset link failed to send', [
                'email' => $email,
                'status' => $status
            ]);

            return [
                'success' => false,
                'error' => __($status)
            ];

        } catch (\Exception $e) {
            Log::error('Exception while sending password reset link', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.'
            ];
        }
    }

    /**
     * Validasi token reset password
     */
    public function validateResetToken(string $email, string $token): array
    {
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$tokenData) {
            Log::warning('Password reset token not found', ['email' => $email]);
            
            return [
                'success' => false,
                'error' => 'Token tidak valid atau sudah kadaluarsa.'
            ];
        }

        // Cek apakah token sudah expired (1 jam)
        $createdAt = Carbon::parse($tokenData->created_at);
        if ($createdAt->addMinutes(self::TOKEN_EXPIRY_MINUTES)->isPast()) {
            $this->deleteExistingTokens($email);
            
            Log::info('Password reset token expired', [
                'email' => $email,
                'created_at' => $tokenData->created_at
            ]);

            return [
                'success' => false,
                'error' => 'Token sudah kadaluarsa. Silakan request reset password lagi.'
            ];
        }

        return ['success' => true];
    }

    /**
     * Clear semua cache terkait password reset
     */
    public function clearResetCache(string $email, string $ip): void
    {
        Cache::forget("pwd_reset_email:{$email}");
        Cache::forget("pwd_reset_ip:{$ip}");
        
        Log::info('Password reset cache cleared', [
            'email' => $email,
            'ip' => $ip
        ]);
    }
}
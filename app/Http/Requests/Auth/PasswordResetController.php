<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\PasswordResetService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    protected PasswordResetService $resetService;

    public function __construct(PasswordResetService $resetService)
    {
        $this->resetService = $resetService;
    }

    /**
     * Show forgot password form
     */
    public function showForgotForm(Request $request)
    {
        return view('auth.forgot-password', [
            'request' => $request,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle forgot password request
     */
    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $email = $request->email;
        $ip = $request->ip();

        // Cek rate limit IP
        if ($this->resetService->checkIpRateLimit($ip)) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan dari IP Anda. Silakan coba lagi dalam 1 jam.'
            ]);
        }

        // Cek rate limit email
        if ($this->resetService->checkEmailRateLimit($email)) {
            return back()->withErrors([
                'email' => 'Terlalu banyak permintaan untuk email ini. Silakan coba lagi dalam 1 jam.'
            ]);
        }

        // Validasi user
        $validation = $this->resetService->validateUser($email);
        if (!$validation['success']) {
            return back()->withErrors(['email' => $validation['error']]);
        }

        // Delete existing tokens
        $deletedCount = $this->resetService->deleteExistingTokens($email);

        // Kirim reset link
        $result = $this->resetService->sendResetLink($email);

        // Increment rate limit
        $this->resetService->incrementRateLimit($ip, $email);

        if ($result['success']) {
            $message = $deletedCount > 0 
                ? 'Link reset password BARU telah dikirim! Link sebelumnya sudah tidak berlaku.'
                : $result['message'];

            return back()->with('status', $message);
        }

        return back()->withErrors(['email' => $result['error']]);
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password - FIXED VERSION
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $newPassword = $request->password;
        $ip = $request->ip();

        Log::info('🔄 Password reset attempt started', [
            'email' => $email,
            'ip' => $ip,
            'timestamp' => now()
        ]);

        // 1️⃣ VALIDASI TOKEN DULU
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$tokenData) {
            Log::warning('❌ Token not found in database', ['email' => $email]);
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // 2️⃣ CEK TOKEN MATCH
        if (!Hash::check($token, $tokenData->token)) {
            Log::warning('❌ Token mismatch', ['email' => $email]);
            return back()->withErrors(['email' => 'Token tidak valid.']);
        }

        // 3️⃣ CEK EXPIRED (60 menit)
        $tokenAge = now()->diffInMinutes($tokenData->created_at);
        if ($tokenAge > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            Log::warning('❌ Token expired', [
                'email' => $email,
                'age_minutes' => $tokenAge
            ]);
            return back()->withErrors(['email' => 'Token sudah kadaluarsa (lebih dari 1 jam).']);
        }

        // 4️⃣ GET USER
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::error('❌ User not found', ['email' => $email]);
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // 5️⃣ LOG PASSWORD SEBELUM UPDATE (untuk debug)
        $oldPasswordHash = $user->password;
        Log::info('📝 Current password hash', [
            'email' => $email,
            'old_hash_preview' => substr($oldPasswordHash, 0, 20) . '...'
        ]);

        // 6️⃣ UPDATE PASSWORD - HATI-HATI DI SINI!
        try {
            // Hash password HANYA 1x
            $newPasswordHash = Hash::make($newPassword);

            Log::info('🔐 New password hashed', [
                'email' => $email,
                'new_hash_preview' => substr($newPasswordHash, 0, 20) . '...'
            ]);

            // Update ke database
            $user->password = $newPasswordHash;
            $user->setRememberToken(Str::random(60));
            $user->save();

            // Verify password tersimpan dengan benar
            $user->refresh();
            $savedHash = $user->password;

            Log::info('💾 Password saved to database', [
                'email' => $email,
                'saved_hash_preview' => substr($savedHash, 0, 20) . '...',
                'hash_changed' => $savedHash !== $oldPasswordHash
            ]);

            // Test apakah password bisa di-check
            $canLogin = Hash::check($newPassword, $user->password);
            Log::info('🧪 Password verification test', [
                'email' => $email,
                'can_login' => $canLogin ? 'YES ✅' : 'NO ❌'
            ]);

            if (!$canLogin) {
                Log::error('❌ CRITICAL: Password saved but cannot verify!', [
                    'email' => $email,
                    'new_password_length' => strlen($newPassword),
                    'saved_hash' => $savedHash
                ]);
                throw new \Exception('Password verification failed after save');
            }

            // 7️⃣ FIRE EVENT
            event(new PasswordReset($user));

            // 8️⃣ CLEAR CACHE & TOKENS
            $this->resetService->clearResetCache($email, $ip);
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            Log::info('✅ Password reset successful', [
                'email' => $email,
                'timestamp' => now()
            ]);

            return redirect()
                ->route('login')
                ->with('status', '✅ Password berhasil direset! Silakan login dengan password baru.');

        } catch (\Exception $e) {
            Log::error('❌ Password reset failed', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat mereset password. Silakan coba lagi.'
            ]);
        }
    }
}
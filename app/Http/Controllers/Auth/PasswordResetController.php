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
     * Show forgot password form (compatible with Breeze)
     */
    public function showForgotForm(Request $request)
    {
        return view('auth.forgot-password', [
            'request' => $request,
        ]);
    }

    /**
     * Handle forgot password request (compatible with Breeze)
     */
    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $email = $request->email;
        $ip = $request->ip();

        Log::channel('security')->info('Password reset requested', [
            'email' => $email,
            'ip' => $ip,
            'timestamp' => now(),
            'type' => 'reset_request'
        ]);

        // Cek rate limit IP
        if ($this->resetService->checkIpRateLimit($ip)) {
            Log::channel('security')->warning('IP rate limit exceeded', ['ip' => $ip]);
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan dari IP Anda. Silakan coba lagi dalam 1 jam.'
            ]);
        }

        // Cek rate limit email
        if ($this->resetService->checkEmailRateLimit($email)) {
            Log::channel('security')->warning('Email rate limit exceeded', ['email' => $email]);
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

        // Kirim reset link menggunakan Laravel Password Broker
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Increment rate limit
        $this->resetService->incrementRateLimit($ip, $email);

        if ($status === Password::RESET_LINK_SENT) {
            $message = $deletedCount > 0 
                ? 'Link reset password BARU telah dikirim! Link sebelumnya sudah tidak berlaku.'
                : 'Link reset password telah dikirim ke email Anda!';

            return back()->with('status', __($message));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form (compatible with Breeze)
     */
    public function showResetForm(Request $request, string $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password - UPDATED for Breeze compatibility
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $newPassword = $request->password;
        $ip = $request->ip();

        Log::channel('security')->info('Password reset attempt started', [
            'email' => $email,
            'ip' => $ip,
            'timestamp' => now()
        ]);

        // Validasi menggunakan Laravel Password Broker
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $oldPasswordHash = $user->password;
                
                Log::info('Updating user password', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'old_hash_preview' => substr($oldPasswordHash, 0, 20) . '...'
                ]);

                // Update password
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Verify the update
                $user->refresh();
                $canLogin = Hash::check($request->password, $user->password);

                if (!$canLogin) {
                    Log::error('CRITICAL: Password verification failed after save', [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);
                    throw new \Exception('Password verification failed');
                }

                // Fire event
                event(new PasswordReset($user));

                Log::info('Password updated successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'hash_changed' => $oldPasswordHash !== $user->password
                ]);
            }
        );

        // Clear cache & tokens setelah reset
        if ($status === Password::PASSWORD_RESET) {
            $this->resetService->clearResetCache($email, $ip);
            
            Log::channel('security')->info('Password reset successful', [
                'email' => $email,
                'ip' => $ip,
                'timestamp' => now(),
                'type' => 'reset_success'
            ]);

            return redirect()
                ->route('login')
                ->with('status', '✅ Password berhasil direset! Silakan login dengan password baru.');
        }

        // Log failure
        Log::channel('security')->warning('Password reset failed', [
            'email' => $email,
            'ip' => $ip,
            'status' => $status,
            'timestamp' => now(),
            'type' => 'reset_failed'
        ]);

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    /**
     * Additional method for admin-triggered password reset
     */
    public function adminTriggeredReset(Request $request, User $user)
    {
        // Only admin can trigger this
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $token = Str::random(64);
            
            // Delete existing tokens
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            
            // Insert new token
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]);

            // Generate reset URL
            $resetUrl = route('password.reset', [
                'token' => $token,
                'email' => $user->email
            ]);

            // Send notification
            $user->notify(new \App\Notifications\AdminTriggeredPasswordReset($resetUrl, $user->name));

            Log::info('Admin triggered password reset', [
                'admin_id' => auth()->id(),
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return back()->with('success', 'Link reset password telah dikirim ke email: ' . $user->email);

        } catch (\Exception $e) {
            Log::error('Failed to send admin-triggered reset link', [
                'admin_id' => auth()->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal mengirim link reset password.');
        }
    }
}
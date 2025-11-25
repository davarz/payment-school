<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class PasswordResetObserver
{
    public function passwordResetRequested($user, $ip)
    {
        Log::channel('security')->info('Password reset requested', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $ip,
            'requested_at' => now(),
            'type' => 'reset_request'
        ]);
    }

    public function passwordResetSuccess($user, $ip)
    {
        Log::channel('security')->info('Password reset successful', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $ip,
            'reset_at' => now(),
            'type' => 'reset_success'
        ]);
    }

    public function passwordResetFailed($email, $ip, $reason)
    {
        Log::channel('security')->warning('Password reset failed', [
            'email' => $email,
            'ip_address' => $ip,
            'failed_at' => now(),
            'reason' => $reason,
            'type' => 'reset_failed'
        ]);
    }
}
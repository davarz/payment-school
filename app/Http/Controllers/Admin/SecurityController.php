<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SecurityController extends Controller
{
    public function securityLogs()
    {
        $logPath = storage_path('logs/security.log');
        $logs = [];
        
        if (file_exists($logPath)) {
            $logs = array_slice(file($logPath), -100); // Last 100 lines
        }

        // Get current reset attempts
        $resetAttempts = [];
        $cacheKeys = Cache::get('cache', []);
        foreach ($cacheKeys as $key => $value) {
            if (str_contains($key, 'password_reset_attempts:') || str_contains($key, 'pwd_reset_ip:')) {
                $resetAttempts[$key] = $value;
            }
        }

        return view('admin.security.logs', compact('logs', 'resetAttempts'));
    }

    public function clearResetAttempts(Request $request)
    {
        $email = $request->email;
        $ip = $request->ip;
        
        if ($email) {
            Cache::forget('password_reset_attempts:' . $email);
        }
        
        if ($ip) {
            Cache::forget('pwd_reset_ip:' . $ip);
        }

        return back()->with('success', 'Reset attempts cleared successfully');
    }
}
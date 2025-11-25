<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class ResetPasswordLimit implements Rule
{
    protected $email;
    protected $maxAttempts = 3;
    protected $decayMinutes = 60;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function passes($attribute, $value)
    {
        $key = 'password_reset_attempts:' . $this->email;
        $attempts = Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            return false;
        }

        // Increment attempts
        Cache::put($key, $attempts + 1, $this->decayMinutes * 60);
        return true;
    }

    public function message()
    {
        return 'Anda telah mencapai batas maksimal reset password (3x percobaan). Coba lagi dalam 1 jam.';
    }
}
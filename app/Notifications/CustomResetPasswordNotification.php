<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CustomResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $userName;

    public function __construct($token, $userName = null)
    {
        $this->token = $token;
        $this->userName = $userName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('🔐 Reset Password - School Payment System')
            ->view('emails.reset-password', [
                'resetUrl' => $resetUrl,
                'userName' => $this->userName ?: $notifiable->name,
                'email' => $notifiable->getEmailForPasswordReset(),
                'expireTime' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60)
            ]);
    }
}
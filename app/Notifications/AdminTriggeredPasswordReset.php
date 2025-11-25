<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminTriggeredPasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    public $resetUrl;
    public $studentName;

    public function __construct($resetUrl, $studentName)
    {
        $this->resetUrl = $resetUrl;
        $this->studentName = $studentName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🔐 Reset Password - School Payment System')
            ->greeting('Halo ' . $this->studentName . '!')
            ->line('Administrator telah melakukan reset password untuk akun Anda.')
            ->line('Untuk keamanan, silakan buat password baru dengan mengklik tombol di bawah:')
            ->action('Buat Password Baru', $this->resetUrl)
            ->line('**Link ini akan kadaluarsa dalam 60 menit.**')
            ->line('Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini.')
            ->line('Keamanan akun Anda adalah prioritas kami.')
            ->salutation('Salam hangat,<br>**Tim IT Sekolah**');
    }
}
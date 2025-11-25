<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // 🔥 Generate bills - OPTIMIZED
        $schedule->command('bills:generate-monthly')
                 ->monthlyOn(1, '03:00') // Jam 3 pagi saat server sepi
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping(30) // Timeout 30 menit
                 ->onOneServer()
                 ->runInBackground();     // 🔥 Jalan di background

        // Password reset cleanup
        $schedule->call(function () {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                ->where('created_at', '<', now()->subDay())
                ->delete();
        })->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
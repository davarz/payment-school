<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Fix500Error extends Command
{
    protected $signature = 'fix:500';
    protected $description = 'Fix HTTP 500 error';

    public function handle()
    {
        $this->info('Memperbaiki HTTP 500 Error...');
        
        // Clear semua cache
        Artisan::call('optimize:clear');
        $this->info('✓ Cache cleared');
        
        // Migrate jika ada perubahan database
        Artisan::call('migrate --force');
        $this->info('✓ Database migrated');
        
        // Generate key jika belum
        Artisan::call('key:generate --force');
        $this->info('✓ App key generated');
        
        // Set permission storage
        chmod(storage_path('logs'), 0755);
        chmod(storage_path('framework'), 0755);
        $this->info('✓ Storage permissions set');
        
        $this->info('✅ Perbaikan selesai! Coba akses aplikasi lagi.');
        
        return 0;
    }
}
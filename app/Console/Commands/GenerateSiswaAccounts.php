<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class GenerateSiswaAccounts extends Command
{
    protected $signature = 'generate:siswa-accounts';
    protected $description = 'Generate siswa accounts from existing data';

    public function handle()
    {
        $siswaRole = Role::where('name', 'siswa')->first();

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'siswa');
        })->whereNotNull('nis')->get();

        foreach ($users as $user) {
            if (!$user->hasRole('siswa')) {
                $user->assignRole($siswaRole);
                $this->info("Assigned siswa role to: {$user->name}");
            }
        }

        $this->info('Siswa accounts generation completed!');
    }
}
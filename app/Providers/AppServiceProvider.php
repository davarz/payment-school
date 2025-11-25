<?php

namespace App\Providers;

use Illuminate\Queue\Connectors\BeanstalkdConnector;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function PHPUnit\Framework\fileExists;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->createRolesAndPermissions();

        if (file_exists(base_path('routes/auth.php'))) {
            require base_path   ('routes/auth.php');
        }
    }

    private function createRolesAndPermissions(): void
    {
        // Create roles
        $roles = ['admin', 'operator', 'siswa'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Create permissions if needed
        // You can add specific permissions here
    }
}
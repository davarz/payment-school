<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test by compiling views
$files = [
    'admin.dashboard',
    'siswa.dashboard',
    'auth.register',
    'auth.login',
];

foreach ($files as $view) {
    try {
        view($view, [])->render();
        echo "✓ $view - OK\n";
    } catch (Exception $e) {
        echo "✗ $view - ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\nAll views compiled successfully!\n";

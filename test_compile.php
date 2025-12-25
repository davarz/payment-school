<?php
require 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    
    $files_to_test = [
        'auth.register',
        'auth.login',
        'admin.dashboard',
        'siswa.dashboard',
    ];
    
    echo "Testing Blade Views:\n";
    echo str_repeat("=", 50) . "\n\n";
    
    foreach ($files_to_test as $view) {
        try {
            echo "Testing $view... ";
            $html = view($view)->render();
            echo "OK\n";
        } catch (Exception $e) {
            echo "ERROR\n";
            echo "  Message: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "All views compiled successfully!\n";
    exit(0);
    
} catch (Exception $e) {
    echo "Fatal error: " . $e->getMessage() . "\n";
    exit(1);
}
?>

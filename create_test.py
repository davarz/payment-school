#!/usr/bin/env python3
"""Test Blade compilation by checking if views can be rendered"""
import sys
import os

# Add Laravel bootstrap
os.chdir(r'c:\laragon\www\payment-school')

# Create a simple PHP test
php_code = '''<?php
require 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    
    $files_to_test = [
        'auth.register',
        'auth.login',
        'admin.dashboard',
        'siswa.dashboard',
    ];
    
    $errors = [];
    
    foreach ($files_to_test as $view) {
        try {
            // Try to compile the view
            echo "Testing $view... ";
            $html = view($view)->render();
            echo "✓ OK\\n";
        } catch (Exception $e) {
            echo "✗ ERROR\\n";
            $errors[] = ["view" => $view, "error" => $e->getMessage()];
        }
    }
    
    if (!empty($errors)) {
        echo "\\nErrors found:\\n";
        foreach ($errors as $err) {
            echo "  - " . $err['view'] . ": " . $err['error'] . "\\n";
        }
        exit(1);
    } else {
        echo "\\nAll views compiled successfully!\\n";
        exit(0);
    }
} catch (Exception $e) {
    echo "Fatal error: " . $e->getMessage() . "\\n";
    exit(1);
}
?>'''

with open('test_compile.php', 'w') as f:
    f.write(php_code)

print("Test script created as test_compile.php")

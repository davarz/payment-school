<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$routes = Route::getRoutes();
echo "Import/Export Routes:\n";
echo str_repeat("=", 60) . "\n";

foreach ($routes as $route) {
    if (strpos($route->getName(), 'import-export') !== false) {
        echo $route->getName() . "\n";
    }
}

echo "\nChecking specific routes:\n";
echo "admin.import-export.export: " . (Route::has('admin.import-export.export') ? "YES" : "NO") . "\n";
echo "admin.import-export.import: " . (Route::has('admin.import-export.import') ? "YES" : "NO") . "\n";
echo "admin.import-export.index: " . (Route::has('admin.import-export.index') ? "YES" : "NO") . "\n";
?>

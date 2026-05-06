<?php

// Set the base path for the Laravel application
$basePath = __DIR__ . '/..';

// Ensure the storage directories exist in /tmp for serverless
$storagePath = '/tmp/storage';
$directories = [
    $storagePath,
    $storagePath . '/app',
    $storagePath . '/framework',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Register the Composer autoloader
require $basePath . '/vendor/autoload.php';

// Bootstrap the application
$app = require_once $basePath . '/bootstrap/app.php';

// Override storage path to use /tmp (writable in serverless)
$app->useStoragePath($storagePath);

// Handle the request
$app->handleRequest(Illuminate\Http\Request::capture());

<?php

// Force configuration for Vercel's read-only filesystem
// The only writable directory is /tmp

if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0755, true);
    mkdir('/tmp/storage/logs', 0755, true);
    mkdir('/tmp/storage/framework/views', 0755, true);
    mkdir('/tmp/storage/framework/sessions', 0755, true);
    mkdir('/tmp/storage/framework/cache', 0755, true);
}

// Override environment variables for serverless compatibility
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_ENV['SESSION_DRIVER'] = 'cookie'; // Use cookies or database for sessions
$_ENV['LOG_CHANNEL'] = 'stderr'; // Log to Vercel console

// Point to the actual Laravel entry point
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Laravel Deployment Error</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

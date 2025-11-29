<?php

use Illuminate\Support\Facades\Mail;

try {
    $transport = Mail::getSymfonyTransport();
    echo "Transport created successfully: " . get_class($transport) . "\n";
    echo "String representation: " . (string) $transport . "\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}


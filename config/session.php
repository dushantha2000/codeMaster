<?php

use Illuminate\Support\Str;

return [
    'driver' => env('SESSION_DRIVER', 'file'),
 
    // Session lifetime in minutes
    'lifetime' => env('SESSION_LIFETIME', 120),
 
    // Expire session on browser close
    'expire_on_close' => false,
 
    // Cookie settings
    'cookie' => env('SESSION_COOKIE', 'laravel_session'),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => true,
    'same_site' => 'lax',
];

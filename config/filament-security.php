<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disposable Email Blocking
    |--------------------------------------------------------------------------
    |
    | Block registration with disposable/temporary email addresses.
    | The package maintains its own list of disposable email domains.
    |
    */

    'disposable_email' => [
        'enabled' => env('FILAMENT_SECURITY_DISPOSABLE_EMAIL', true),

        // Cache the domain list (recommended for performance)
        'cache_enabled' => env('FILAMENT_SECURITY_CACHE', true),

        // Cache TTL in minutes (default: 24 hours)
        'cache_ttl' => 1440,

        // Additional domains to block (beyond the built-in list)
        'custom_domains' => [
            // 'example-temp.com',
        ],

        // Domains to allow even if they appear in the block list
        'whitelisted_domains' => [
            // 'company-temp.com',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Honeypot Protection
    |--------------------------------------------------------------------------
    |
    | Protect registration forms against bots using honeypot fields.
    | Uses spatie/laravel-honeypot under the hood.
    |
    */

    'honeypot' => [
        'enabled' => env('FILAMENT_SECURITY_HONEYPOT', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cloudflare IP Blocking
    |--------------------------------------------------------------------------
    |
    | Automatically block suspicious IPs via Cloudflare WAF.
    | Requires Cloudflare API credentials.
    |
    */

    'cloudflare' => [
        'enabled' => env('FILAMENT_SECURITY_CLOUDFLARE', false),

        'api_token' => env('CLOUDFLARE_API_TOKEN'),
        'zone_id' => env('CLOUDFLARE_ZONE_ID'),

        // Max failed login attempts before blocking IP on Cloudflare
        'max_attempts' => env('FILAMENT_SECURITY_CF_MAX_ATTEMPTS', 5),

        // Time window in minutes to count attempts
        'decay_minutes' => env('FILAMENT_SECURITY_CF_DECAY_MINUTES', 30),

        // Block mode: 'block' or 'challenge' (shows captcha)
        'mode' => env('FILAMENT_SECURITY_CF_MODE', 'block'),

        // Note for the Cloudflare rule
        'note_prefix' => 'FilamentSecurity: Auto-blocked',
    ],

];

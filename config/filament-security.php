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
    | DNS/MX Verification
    |--------------------------------------------------------------------------
    |
    | Verify that email domains have valid MX or A/AAAA records.
    | Blocks domains that cannot receive email (no mail infrastructure).
    | Also detects suspicious MX targets (localhost, private IPs).
    |
    */

    'dns_verification' => [
        'enabled' => env('FILAMENT_SECURITY_DNS_CHECK', true),

        // Cache DNS results (recommended to avoid repeated lookups)
        'cache_enabled' => env('FILAMENT_SECURITY_CACHE', true),

        // Cache TTL in minutes (default: 1 hour)
        'cache_ttl' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Age Verification (RDAP)
    |--------------------------------------------------------------------------
    |
    | Check domain registration age via RDAP (successor to WHOIS).
    | Blocks recently registered domains commonly used for spam/fraud.
    |
    */

    'domain_age' => [
        'enabled' => env('FILAMENT_SECURITY_DOMAIN_AGE', false),

        // Minimum domain age in days
        'min_days' => env('FILAMENT_SECURITY_DOMAIN_MIN_DAYS', 30),

        // Block registration when RDAP lookup fails (conservative: false)
        'block_on_failure' => env('FILAMENT_SECURITY_DOMAIN_AGE_STRICT', false),

        // Cache RDAP results (recommended — external HTTP calls)
        'cache_enabled' => env('FILAMENT_SECURITY_CACHE', true),

        // Cache TTL in minutes (default: 24 hours)
        'cache_ttl' => 1440,
    ],

    /*
    |--------------------------------------------------------------------------
    | Single Session (One Device Per User)
    |--------------------------------------------------------------------------
    |
    | Enforce one active session per user. When a user logs in on a new
    | browser/device, all previous sessions are terminated immediately.
    | Works with database and Redis session drivers.
    |
    */

    'single_session' => [
        'enabled' => env('FILAMENT_SECURITY_SINGLE_SESSION', false),
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

    /*
    |--------------------------------------------------------------------------
    | Malicious Scan Protection
    |--------------------------------------------------------------------------
    |
    | Block requests to known exploit paths, config files, web shells,
    | and CMS admin pages. Returns 404 and logs the attempt.
    |
    */

    'malicious_scan' => [
        'enabled' => env('FILAMENT_SECURITY_MALICIOUS_SCAN', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Event Log
    |--------------------------------------------------------------------------
    |
    | Record all security events (blocked emails, honeypot triggers,
    | IP blocks, etc.) with a Filament dashboard for monitoring.
    | Requires running the migration for the security_events table.
    |
    */

    'event_log' => [
        'enabled' => env('FILAMENT_SECURITY_EVENT_LOG', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | IpInfo Integration (Optional)
    |--------------------------------------------------------------------------
    |
    | Enrich security events with IP geolocation data from ipinfo.io.
    | Only used if a token is provided. Get a free token at ipinfo.io.
    |
    */

    'ipinfo' => [
        'token' => env('IPINFO_TOKEN'),
        'timeout' => 5,

        // Cache TTL in minutes (default: 24 hours)
        'cache_ttl' => 1440,
    ],

];

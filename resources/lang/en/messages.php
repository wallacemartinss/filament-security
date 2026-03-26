<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disposable Email
    |--------------------------------------------------------------------------
    */

    'disposable_email' => 'Disposable email addresses are not allowed.',
    'disposable_email_blocked' => 'This email provider is not accepted. Please use a permanent email address.',

    /*
    |--------------------------------------------------------------------------
    | DNS/MX Verification
    |--------------------------------------------------------------------------
    */

    'dns_mx_suspicious' => 'This email domain does not appear to have valid mail servers. Please use a valid email address.',

    /*
    |--------------------------------------------------------------------------
    | Domain Age (RDAP)
    |--------------------------------------------------------------------------
    */

    'domain_too_young' => 'This email domain was registered too recently (minimum :days days required). Please use an established email provider.',

    /*
    |--------------------------------------------------------------------------
    | Single Session
    |--------------------------------------------------------------------------
    */

    'session_terminated' => 'Your session was terminated because your account was logged in from another device.',

    /*
    |--------------------------------------------------------------------------
    | Honeypot
    |--------------------------------------------------------------------------
    */

    'honeypot_triggered' => 'Spam detected.',

    /*
    |--------------------------------------------------------------------------
    | Cloudflare IP Blocking
    |--------------------------------------------------------------------------
    */

    'ip_blocked' => 'Your IP has been blocked due to suspicious activity.',
    'ip_blocked_reason_failed_login' => 'Too many failed login attempts.',
    'ip_blocked_reason_bot' => 'Bot detected (honeypot triggered).',
    'ip_blocked_reason_manual' => 'Manual block via CLI.',
    'ip_already_blocked' => 'This IP is already blocked.',
    'ip_not_found' => 'IP not found in the blocked list.',
    'ip_unblocked' => 'IP has been unblocked.',

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    */

    'command' => [
        'domain_added' => "Domain ':domain' added to the custom blocklist.",
        'domain_removed' => "Domain ':domain' removed from the custom blocklist.",
        'domain_already_blocked' => "Domain ':domain' is already blocked.",
        'domain_not_found' => "Domain ':domain' was not found in the custom blocklist.",
        'domain_invalid' => 'Invalid domain format.',
        'no_custom_domains' => 'No custom domains added yet.',
        'no_blocked_ips' => 'No blocked IPs.',
        'ip_blocked_success' => "IP ':ip' has been blocked.",
        'ip_blocked_failed' => "Failed to block IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' has been unblocked.",
        'install_success' => 'Filament Security installed successfully!',
    ],

];

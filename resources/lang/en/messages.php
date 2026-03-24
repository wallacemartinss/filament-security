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

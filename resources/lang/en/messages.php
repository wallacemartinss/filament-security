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

    /*
    |--------------------------------------------------------------------------
    | Event Log
    |--------------------------------------------------------------------------
    */

    'event_log' => [
        'navigation_group' => 'System',
        'navigation_label' => 'Security Events',
        'model_label' => 'Security Event',
        'plural_model_label' => 'Security Events',
        'badge_tooltip' => 'Events today',

        'tabs' => [
            'email' => 'Email',
            'bot_scan' => 'Bots & Scans',
            'session' => 'Session',
            'auth' => 'Auth',
            'ip_management' => 'IP Management',
        ],

        'table' => [
            'type' => 'Type',
            'location' => 'Location',
            'domain' => 'Domain',
            'trigger' => 'Trigger',
            'count' => 'Count',
            'date' => 'Date',
        ],

        'stats' => [
            'events_today' => 'Events Today',
            'ips_blocked_today' => 'IPs Blocked Today',
            'auto_blocked' => 'Auto-blocked',
            'top_threat' => 'Top Threat (7d)',
            'unique_ips' => 'Unique IPs (7d)',
        ],

        'charts' => [
            'threat_activity' => 'Threat Activity (14 days)',
            'events_by_type' => 'Events by Type (7 days)',
            'top_attackers' => 'Top Offending IPs (7 days)',
            'no_threats' => 'No threats detected',
            'no_threats_description' => 'No security events in the last 7 days.',
            'events' => 'Events',
            'types' => 'Types',
            'last_seen' => 'Last Seen',
            'banned' => 'Banned',
            'active' => 'Active',
        ],

        'actions' => [
            'backfill_label' => 'Backfill Locations (:count IPs)',
            'backfill_heading' => 'Backfill IP Locations',
            'backfill_description' => 'Enrich :count unique IPs without location data via IpInfo API.',
            'backfill_submit' => 'Start Backfill',
            'backfill_complete' => 'Backfill complete',
            'backfill_result' => 'Enriched :enriched IPs (:failed failed/private)',
            'ipinfo_not_configured' => 'IpInfo not configured',
            'ipinfo_not_configured_body' => 'Set IPINFO_TOKEN in your .env file.',
            'unban_label' => 'Unban IP',
            'unban_heading' => 'Unban IP Address',
            'unban_description' => 'Remove block for IP :ip?',
            'unban_success' => 'IP :ip unbanned',
        ],
    ],

];

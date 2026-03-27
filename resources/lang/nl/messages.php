<?php

return [

    'disposable_email' => 'Wegwerp e-mailadressen zijn niet toegestaan.',
    'disposable_email_blocked' => 'Deze e-mailprovider wordt niet geaccepteerd. Gebruik alstublieft een permanent e-mailadres.',

    'dns_mx_suspicious' => 'Dit e-maildomein lijkt geen geldige mailservers te hebben. Gebruik alstublieft een geldig e-mailadres.',
    'domain_too_young' => 'Dit e-maildomein is te recent geregistreerd (minimaal :days dagen vereist). Gebruik alstublieft een gevestigde e-mailprovider.',

    'session_terminated' => 'Uw sessie is beëindigd omdat uw account is ingelogd vanaf een ander apparaat.',

    'honeypot_triggered' => 'Spam gedetecteerd.',

    'ip_blocked' => 'Uw IP is geblokkeerd vanwege verdachte activiteit.',
    'ip_blocked_reason_failed_login' => 'Te veel mislukte inlogpogingen.',
    'ip_blocked_reason_bot' => 'Bot gedetecteerd (honeypot geactiveerd).',
    'ip_blocked_reason_manual' => 'Handmatige blokkering via CLI.',
    'ip_already_blocked' => 'Dit IP is al geblokkeerd.',
    'ip_not_found' => 'IP niet gevonden in de blokkeerlijst.',
    'ip_unblocked' => 'IP is gedeblokkeerd.',

    'command' => [
        'domain_added' => "Domein ':domain' toegevoegd aan de blokkeerlijst.",
        'domain_removed' => "Domein ':domain' verwijderd uit de blokkeerlijst.",
        'domain_already_blocked' => "Domein ':domain' is al geblokkeerd.",
        'domain_not_found' => "Domein ':domain' niet gevonden in de blokkeerlijst.",
        'domain_invalid' => 'Ongeldig domeinformaat.',
        'no_custom_domains' => 'Nog geen aangepaste domeinen toegevoegd.',
        'no_blocked_ips' => "Geen geblokkeerde IP's.",
        'ip_blocked_success' => "IP ':ip' is geblokkeerd.",
        'ip_blocked_failed' => "Blokkering van IP ':ip' mislukt.",
        'ip_unblocked_success' => "IP ':ip' is gedeblokkeerd.",
        'install_success' => 'Filament Security succesvol geïnstalleerd!',
    ],

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

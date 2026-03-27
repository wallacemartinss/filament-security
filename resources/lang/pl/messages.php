<?php

return [

    'disposable_email' => 'Jednorazowe adresy e-mail nie są dozwolone.',
    'disposable_email_blocked' => 'Ten dostawca poczty e-mail nie jest akceptowany. Proszę użyć stałego adresu e-mail.',

    'dns_mx_suspicious' => 'Ta domena e-mail nie wydaje się mieć prawidłowych serwerów pocztowych. Proszę użyć prawidłowego adresu e-mail.',
    'domain_too_young' => 'Ta domena e-mail została zarejestrowana zbyt niedawno (wymagane minimum :days dni). Proszę użyć ustalonego dostawcy poczty e-mail.',

    'session_terminated' => 'Twoja sesja została zakończona, ponieważ Twoje konto zostało zalogowane z innego urządzenia.',

    'honeypot_triggered' => 'Wykryto spam.',

    'ip_blocked' => 'Twój adres IP został zablokowany z powodu podejrzanej aktywności.',
    'ip_blocked_reason_failed_login' => 'Zbyt wiele nieudanych prób logowania.',
    'ip_blocked_reason_bot' => 'Wykryto bota (honeypot uruchomiony).',
    'ip_blocked_reason_manual' => 'Ręczna blokada przez CLI.',
    'ip_already_blocked' => 'Ten adres IP jest już zablokowany.',
    'ip_not_found' => 'IP nie znaleziony na liście zablokowanych.',
    'ip_unblocked' => 'IP został odblokowany.',

    'command' => [
        'domain_added' => "Domena ':domain' dodana do listy blokowanych.",
        'domain_removed' => "Domena ':domain' usunięta z listy blokowanych.",
        'domain_already_blocked' => "Domena ':domain' jest już zablokowana.",
        'domain_not_found' => "Domena ':domain' nie znaleziona na liście blokowanych.",
        'domain_invalid' => 'Nieprawidłowy format domeny.',
        'no_custom_domains' => 'Nie dodano jeszcze niestandardowych domen.',
        'no_blocked_ips' => 'Brak zablokowanych adresów IP.',
        'ip_blocked_success' => "IP ':ip' został zablokowany.",
        'ip_blocked_failed' => "Nie udało się zablokować IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' został odblokowany.",
        'install_success' => 'Filament Security zainstalowany pomyślnie!',
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

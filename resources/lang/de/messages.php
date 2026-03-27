<?php

return [

    'disposable_email' => 'Einweg-E-Mail-Adressen sind nicht erlaubt.',
    'disposable_email_blocked' => 'Dieser E-Mail-Anbieter wird nicht akzeptiert. Bitte verwenden Sie eine permanente E-Mail-Adresse.',

    'dns_mx_suspicious' => 'Diese E-Mail-Domain scheint keine gültigen Mailserver zu haben. Bitte verwenden Sie eine gültige E-Mail-Adresse.',
    'domain_too_young' => 'Diese E-Mail-Domain wurde zu kürzlich registriert (mindestens :days Tage erforderlich). Bitte verwenden Sie einen etablierten E-Mail-Anbieter.',

    'session_terminated' => 'Ihre Sitzung wurde beendet, da Ihr Konto von einem anderen Gerät angemeldet wurde.',

    'honeypot_triggered' => 'Spam erkannt.',

    'ip_blocked' => 'Ihre IP wurde aufgrund verdächtiger Aktivitäten gesperrt.',
    'ip_blocked_reason_failed_login' => 'Zu viele fehlgeschlagene Anmeldeversuche.',
    'ip_blocked_reason_bot' => 'Bot erkannt (Honeypot ausgelöst).',
    'ip_blocked_reason_manual' => 'Manuelle Sperrung über CLI.',
    'ip_already_blocked' => 'Diese IP ist bereits gesperrt.',
    'ip_not_found' => 'IP nicht in der Sperrliste gefunden.',
    'ip_unblocked' => 'IP wurde entsperrt.',

    'command' => [
        'domain_added' => "Domain ':domain' zur Sperrliste hinzugefügt.",
        'domain_removed' => "Domain ':domain' aus der Sperrliste entfernt.",
        'domain_already_blocked' => "Domain ':domain' ist bereits gesperrt.",
        'domain_not_found' => "Domain ':domain' nicht in der Sperrliste gefunden.",
        'domain_invalid' => 'Ungültiges Domain-Format.',
        'no_custom_domains' => 'Keine benutzerdefinierten Domains hinzugefügt.',
        'no_blocked_ips' => 'Keine gesperrten IPs.',
        'ip_blocked_success' => "IP ':ip' wurde gesperrt.",
        'ip_blocked_failed' => "Fehler beim Sperren der IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' wurde entsperrt.",
        'install_success' => 'Filament Security erfolgreich installiert!',
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

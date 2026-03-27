<?php

return [

    'disposable_email' => 'Одноразові адреси електронної пошти не дозволені.',
    'disposable_email_blocked' => 'Цей провайдер електронної пошти не приймається. Будь ласка, використовуйте постійну адресу електронної пошти.',

    'dns_mx_suspicious' => 'Цей домен електронної пошти, схоже, не має дійсних поштових серверів. Будь ласка, використовуйте дійсну адресу електронної пошти.',
    'domain_too_young' => 'Цей домен електронної пошти був зареєстрований занадто нещодавно (мінімум :days днів). Будь ласка, використовуйте усталеного провайдера електронної пошти.',

    'session_terminated' => 'Вашу сесію було завершено, оскільки у ваш обліковий запис увійшли з іншого пристрою.',

    'honeypot_triggered' => 'Виявлено спам.',

    'ip_blocked' => 'Вашу IP заблоковано через підозрілу активність.',
    'ip_blocked_reason_failed_login' => 'Забагато невдалих спроб входу.',
    'ip_blocked_reason_bot' => 'Виявлено бота (спрацювала пастка).',
    'ip_blocked_reason_manual' => 'Ручне блокування через CLI.',
    'ip_already_blocked' => 'Цю IP вже заблоковано.',
    'ip_not_found' => 'IP не знайдено у списку заблокованих.',
    'ip_unblocked' => 'IP розблоковано.',

    'command' => [
        'domain_added' => "Домен ':domain' додано до списку блокування.",
        'domain_removed' => "Домен ':domain' видалено зі списку блокування.",
        'domain_already_blocked' => "Домен ':domain' вже заблоковано.",
        'domain_not_found' => "Домен ':domain' не знайдено у списку блокування.",
        'domain_invalid' => 'Невірний формат домену.',
        'no_custom_domains' => 'Користувацькі домени ще не додані.',
        'no_blocked_ips' => 'Заблокованих IP немає.',
        'ip_blocked_success' => "IP ':ip' заблоковано.",
        'ip_blocked_failed' => "Не вдалося заблокувати IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' розблоковано.",
        'install_success' => 'Filament Security успішно встановлено!',
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

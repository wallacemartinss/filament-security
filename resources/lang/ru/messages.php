<?php

return [

    'disposable_email' => 'Одноразовые адреса электронной почты не допускаются.',
    'disposable_email_blocked' => 'Этот провайдер электронной почты не принимается. Пожалуйста, используйте постоянный адрес электронной почты.',

    'dns_mx_suspicious' => 'У этого домена электронной почты, похоже, нет действующих почтовых серверов. Пожалуйста, используйте действительный адрес электронной почты.',
    'domain_too_young' => 'Этот домен электронной почты был зарегистрирован слишком недавно (минимум :days дней). Пожалуйста, используйте устоявшегося провайдера электронной почты.',

    'session_terminated' => 'Ваша сессия была завершена, так как в ваш аккаунт был выполнен вход с другого устройства.',

    'honeypot_triggered' => 'Обнаружен спам.',

    'ip_blocked' => 'Ваш IP заблокирован из-за подозрительной активности.',
    'ip_blocked_reason_failed_login' => 'Слишком много неудачных попыток входа.',
    'ip_blocked_reason_bot' => 'Обнаружен бот (сработала ловушка).',
    'ip_blocked_reason_manual' => 'Ручная блокировка через CLI.',
    'ip_already_blocked' => 'Этот IP уже заблокирован.',
    'ip_not_found' => 'IP не найден в списке заблокированных.',
    'ip_unblocked' => 'IP разблокирован.',

    'command' => [
        'domain_added' => "Домен ':domain' добавлен в список блокировки.",
        'domain_removed' => "Домен ':domain' удалён из списка блокировки.",
        'domain_already_blocked' => "Домен ':domain' уже заблокирован.",
        'domain_not_found' => "Домен ':domain' не найден в списке блокировки.",
        'domain_invalid' => 'Неверный формат домена.',
        'no_custom_domains' => 'Пользовательские домены ещё не добавлены.',
        'no_blocked_ips' => 'Заблокированных IP нет.',
        'ip_blocked_success' => "IP ':ip' заблокирован.",
        'ip_blocked_failed' => "Не удалось заблокировать IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' разблокирован.",
        'install_success' => 'Filament Security успешно установлен!',
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

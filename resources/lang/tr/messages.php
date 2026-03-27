<?php

return [

    'disposable_email' => 'Tek kullanımlık e-posta adreslerine izin verilmemektedir.',
    'disposable_email_blocked' => 'Bu e-posta sağlayıcısı kabul edilmemektedir. Lütfen kalıcı bir e-posta adresi kullanın.',

    'dns_mx_suspicious' => 'Bu e-posta alan adının geçerli posta sunucuları yok gibi görünüyor. Lütfen geçerli bir e-posta adresi kullanın.',
    'domain_too_young' => 'Bu e-posta alan adı çok yakın zamanda kaydedilmiş (en az :days gün gerekli). Lütfen yerleşik bir e-posta sağlayıcısı kullanın.',

    'session_terminated' => 'Hesabınız başka bir cihazdan giriş yapıldığı için oturumunuz sonlandırıldı.',

    'honeypot_triggered' => 'Spam algılandı.',

    'ip_blocked' => 'Şüpheli aktivite nedeniyle IP adresiniz engellendi.',
    'ip_blocked_reason_failed_login' => 'Çok fazla başarısız giriş denemesi.',
    'ip_blocked_reason_bot' => 'Bot algılandı (honeypot tetiklendi).',
    'ip_blocked_reason_manual' => 'CLI üzerinden manuel engelleme.',
    'ip_already_blocked' => 'Bu IP zaten engellenmiş.',
    'ip_not_found' => 'IP engelleme listesinde bulunamadı.',
    'ip_unblocked' => 'IP engeli kaldırıldı.',

    'command' => [
        'domain_added' => "':domain' alan adı engelleme listesine eklendi.",
        'domain_removed' => "':domain' alan adı engelleme listesinden kaldırıldı.",
        'domain_already_blocked' => "':domain' alan adı zaten engellenmiş.",
        'domain_not_found' => "':domain' alan adı engelleme listesinde bulunamadı.",
        'domain_invalid' => 'Geçersiz alan adı formatı.',
        'no_custom_domains' => 'Henüz özel alan adı eklenmemiş.',
        'no_blocked_ips' => 'Engellenmiş IP yok.',
        'ip_blocked_success' => "IP ':ip' engellendi.",
        'ip_blocked_failed' => "IP ':ip' engellenemedi.",
        'ip_unblocked_success' => "IP ':ip' engeli kaldırıldı.",
        'install_success' => 'Filament Security başarıyla kuruldu!',
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

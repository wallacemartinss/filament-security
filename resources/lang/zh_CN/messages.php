<?php

return [

    'disposable_email' => '不允许使用一次性电子邮件地址。',
    'disposable_email_blocked' => '此电子邮件提供商不被接受。请使用永久电子邮件地址。',

    'dns_mx_suspicious' => '此电子邮件域似乎没有有效的邮件服务器。请使用有效的电子邮件地址。',
    'domain_too_young' => '此电子邮件域注册时间过短（最少需要 :days 天）。请使用成熟的电子邮件提供商。',

    'session_terminated' => '您的会话已被终止，因为您的账户已从另一台设备登录。',

    'honeypot_triggered' => '检测到垃圾邮件。',

    'ip_blocked' => '由于可疑活动，您的IP已被封锁。',
    'ip_blocked_reason_failed_login' => '登录失败次数过多。',
    'ip_blocked_reason_bot' => '检测到机器人（蜜罐触发）。',
    'ip_blocked_reason_manual' => '通过CLI手动封锁。',
    'ip_already_blocked' => '此IP已被封锁。',
    'ip_not_found' => '在封锁列表中未找到此IP。',
    'ip_unblocked' => 'IP已解封。',

    'command' => [
        'domain_added' => "域名 ':domain' 已添加到封锁列表。",
        'domain_removed' => "域名 ':domain' 已从封锁列表中移除。",
        'domain_already_blocked' => "域名 ':domain' 已被封锁。",
        'domain_not_found' => "在封锁列表中未找到域名 ':domain'。",
        'domain_invalid' => '无效的域名格式。',
        'no_custom_domains' => '尚未添加自定义域名。',
        'no_blocked_ips' => '没有被封锁的IP。',
        'ip_blocked_success' => "IP ':ip' 已被封锁。",
        'ip_blocked_failed' => "封锁IP ':ip' 失败。",
        'ip_unblocked_success' => "IP ':ip' 已解封。",
        'install_success' => 'Filament Security 安装成功！',
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

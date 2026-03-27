<?php

return [

    'disposable_email' => '일회용 이메일 주소는 허용되지 않습니다.',
    'disposable_email_blocked' => '이 이메일 제공업체는 허용되지 않습니다. 영구적인 이메일 주소를 사용해 주세요.',

    'dns_mx_suspicious' => '이 이메일 도메인에 유효한 메일 서버가 없는 것 같습니다. 유효한 이메일 주소를 사용해 주세요.',
    'domain_too_young' => '이 이메일 도메인이 너무 최근에 등록되었습니다 (최소 :days일 필요). 확립된 이메일 제공업체를 사용해 주세요.',

    'session_terminated' => '다른 기기에서 계정에 로그인하여 세션이 종료되었습니다.',

    'honeypot_triggered' => '스팸이 감지되었습니다.',

    'ip_blocked' => '의심스러운 활동으로 인해 IP가 차단되었습니다.',
    'ip_blocked_reason_failed_login' => '로그인 시도 실패 횟수가 너무 많습니다.',
    'ip_blocked_reason_bot' => '봇이 감지되었습니다 (허니팟 작동).',
    'ip_blocked_reason_manual' => 'CLI를 통한 수동 차단.',
    'ip_already_blocked' => '이 IP는 이미 차단되어 있습니다.',
    'ip_not_found' => '차단 목록에서 IP를 찾을 수 없습니다.',
    'ip_unblocked' => 'IP 차단이 해제되었습니다.',

    'command' => [
        'domain_added' => "도메인 ':domain'이(가) 차단 목록에 추가되었습니다.",
        'domain_removed' => "도메인 ':domain'이(가) 차단 목록에서 제거되었습니다.",
        'domain_already_blocked' => "도메인 ':domain'은(는) 이미 차단되어 있습니다.",
        'domain_not_found' => "차단 목록에서 도메인 ':domain'을(를) 찾을 수 없습니다.",
        'domain_invalid' => '잘못된 도메인 형식입니다.',
        'no_custom_domains' => '추가된 사용자 정의 도메인이 없습니다.',
        'no_blocked_ips' => '차단된 IP가 없습니다.',
        'ip_blocked_success' => "IP ':ip'이(가) 차단되었습니다.",
        'ip_blocked_failed' => "IP ':ip' 차단에 실패했습니다.",
        'ip_unblocked_success' => "IP ':ip' 차단이 해제되었습니다.",
        'install_success' => 'Filament Security가 성공적으로 설치되었습니다!',
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

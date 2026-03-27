<?php

return [

    'disposable_email' => '使い捨てメールアドレスは許可されていません。',
    'disposable_email_blocked' => 'このメールプロバイダーは受け付けられません。恒久的なメールアドレスをご使用ください。',

    'dns_mx_suspicious' => 'このメールドメインには有効なメールサーバーがないようです。有効なメールアドレスをご使用ください。',
    'domain_too_young' => 'このメールドメインは登録されたばかりです（最低:days日必要）。確立されたメールプロバイダーをご使用ください。',

    'session_terminated' => '別のデバイスからアカウントにログインされたため、セッションが終了しました。',

    'honeypot_triggered' => 'スパムが検出されました。',

    'ip_blocked' => '不審な活動のため、IPがブロックされました。',
    'ip_blocked_reason_failed_login' => 'ログイン試行の失敗回数が多すぎます。',
    'ip_blocked_reason_bot' => 'ボットを検出しました（ハニーポット発動）。',
    'ip_blocked_reason_manual' => 'CLIによる手動ブロック。',
    'ip_already_blocked' => 'このIPは既にブロックされています。',
    'ip_not_found' => 'ブロックリストにIPが見つかりません。',
    'ip_unblocked' => 'IPのブロックが解除されました。',

    'command' => [
        'domain_added' => "ドメイン ':domain' をブロックリストに追加しました。",
        'domain_removed' => "ドメイン ':domain' をブロックリストから削除しました。",
        'domain_already_blocked' => "ドメイン ':domain' は既にブロックされています。",
        'domain_not_found' => "ドメイン ':domain' がブロックリストに見つかりません。",
        'domain_invalid' => '無効なドメイン形式です。',
        'no_custom_domains' => 'カスタムドメインはまだ追加されていません。',
        'no_blocked_ips' => 'ブロックされたIPはありません。',
        'ip_blocked_success' => "IP ':ip' をブロックしました。",
        'ip_blocked_failed' => "IP ':ip' のブロックに失敗しました。",
        'ip_unblocked_success' => "IP ':ip' のブロックを解除しました。",
        'install_success' => 'Filament Securityのインストールが完了しました！',
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

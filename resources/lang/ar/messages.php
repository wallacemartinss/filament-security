<?php

return [

    'disposable_email' => 'عناوين البريد الإلكتروني المؤقتة غير مسموح بها.',
    'disposable_email_blocked' => 'مزود البريد الإلكتروني هذا غير مقبول. يرجى استخدام عنوان بريد إلكتروني دائم.',

    'dns_mx_suspicious' => 'يبدو أن نطاق البريد الإلكتروني هذا لا يحتوي على خوادم بريد صالحة. يرجى استخدام عنوان بريد إلكتروني صالح.',
    'domain_too_young' => 'تم تسجيل نطاق البريد الإلكتروني هذا مؤخرًا جدًا (مطلوب :days يوم كحد أدنى). يرجى استخدام مزود بريد إلكتروني معروف.',

    'session_terminated' => 'تم إنهاء جلستك لأنه تم تسجيل الدخول إلى حسابك من جهاز آخر.',

    'honeypot_triggered' => 'تم اكتشاف بريد مزعج.',

    'ip_blocked' => 'تم حظر عنوان IP الخاص بك بسبب نشاط مشبوه.',
    'ip_blocked_reason_failed_login' => 'محاولات تسجيل دخول فاشلة كثيرة جداً.',
    'ip_blocked_reason_bot' => 'تم اكتشاف بوت (تم تفعيل المصيدة).',
    'ip_blocked_reason_manual' => 'حظر يدوي عبر سطر الأوامر.',
    'ip_already_blocked' => 'عنوان IP هذا محظور بالفعل.',
    'ip_not_found' => 'لم يتم العثور على IP في قائمة المحظورين.',
    'ip_unblocked' => 'تم إلغاء حظر IP.',

    'command' => [
        'domain_added' => "تمت إضافة النطاق ':domain' إلى قائمة الحظر.",
        'domain_removed' => "تمت إزالة النطاق ':domain' من قائمة الحظر.",
        'domain_already_blocked' => "النطاق ':domain' محظور بالفعل.",
        'domain_not_found' => "لم يتم العثور على النطاق ':domain' في قائمة الحظر.",
        'domain_invalid' => 'تنسيق النطاق غير صالح.',
        'no_custom_domains' => 'لم تتم إضافة نطاقات مخصصة بعد.',
        'no_blocked_ips' => 'لا توجد عناوين IP محظورة.',
        'ip_blocked_success' => "تم حظر IP ':ip'.",
        'ip_blocked_failed' => "فشل حظر IP ':ip'.",
        'ip_unblocked_success' => "تم إلغاء حظر IP ':ip'.",
        'install_success' => 'تم تثبيت Filament Security بنجاح!',
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

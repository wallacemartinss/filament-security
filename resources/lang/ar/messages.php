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

];

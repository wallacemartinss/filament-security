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

];

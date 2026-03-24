<?php

return [

    'disposable_email' => 'Одноразові адреси електронної пошти не дозволені.',
    'disposable_email_blocked' => 'Цей провайдер електронної пошти не приймається. Будь ласка, використовуйте постійну адресу електронної пошти.',

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

];

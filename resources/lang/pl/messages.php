<?php

return [

    'disposable_email' => 'Jednorazowe adresy e-mail nie są dozwolone.',
    'disposable_email_blocked' => 'Ten dostawca poczty e-mail nie jest akceptowany. Proszę użyć stałego adresu e-mail.',

    'dns_mx_suspicious' => 'Ta domena e-mail nie wydaje się mieć prawidłowych serwerów pocztowych. Proszę użyć prawidłowego adresu e-mail.',
    'domain_too_young' => 'Ta domena e-mail została zarejestrowana zbyt niedawno (wymagane minimum :days dni). Proszę użyć ustalonego dostawcy poczty e-mail.',

    'session_terminated' => 'Twoja sesja została zakończona, ponieważ Twoje konto zostało zalogowane z innego urządzenia.',

    'honeypot_triggered' => 'Wykryto spam.',

    'ip_blocked' => 'Twój adres IP został zablokowany z powodu podejrzanej aktywności.',
    'ip_blocked_reason_failed_login' => 'Zbyt wiele nieudanych prób logowania.',
    'ip_blocked_reason_bot' => 'Wykryto bota (honeypot uruchomiony).',
    'ip_blocked_reason_manual' => 'Ręczna blokada przez CLI.',
    'ip_already_blocked' => 'Ten adres IP jest już zablokowany.',
    'ip_not_found' => 'IP nie znaleziony na liście zablokowanych.',
    'ip_unblocked' => 'IP został odblokowany.',

    'command' => [
        'domain_added' => "Domena ':domain' dodana do listy blokowanych.",
        'domain_removed' => "Domena ':domain' usunięta z listy blokowanych.",
        'domain_already_blocked' => "Domena ':domain' jest już zablokowana.",
        'domain_not_found' => "Domena ':domain' nie znaleziona na liście blokowanych.",
        'domain_invalid' => 'Nieprawidłowy format domeny.',
        'no_custom_domains' => 'Nie dodano jeszcze niestandardowych domen.',
        'no_blocked_ips' => 'Brak zablokowanych adresów IP.',
        'ip_blocked_success' => "IP ':ip' został zablokowany.",
        'ip_blocked_failed' => "Nie udało się zablokować IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' został odblokowany.",
        'install_success' => 'Filament Security zainstalowany pomyślnie!',
    ],

];

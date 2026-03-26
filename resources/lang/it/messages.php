<?php

return [

    'disposable_email' => 'Gli indirizzi e-mail usa e getta non sono consentiti.',
    'disposable_email_blocked' => 'Questo provider di posta elettronica non è accettato. Si prega di utilizzare un indirizzo e-mail permanente.',

    'dns_mx_suspicious' => 'Questo dominio e-mail non sembra avere server di posta validi. Si prega di utilizzare un indirizzo e-mail valido.',
    'domain_too_young' => 'Questo dominio e-mail è stato registrato troppo recentemente (minimo :days giorni richiesti). Si prega di utilizzare un provider di posta consolidato.',

    'session_terminated' => 'La tua sessione è stata terminata perché il tuo account è stato connesso da un altro dispositivo.',

    'honeypot_triggered' => 'Spam rilevato.',

    'ip_blocked' => 'Il tuo IP è stato bloccato a causa di attività sospette.',
    'ip_blocked_reason_failed_login' => 'Troppi tentativi di accesso falliti.',
    'ip_blocked_reason_bot' => 'Bot rilevato (honeypot attivato).',
    'ip_blocked_reason_manual' => 'Blocco manuale tramite CLI.',
    'ip_already_blocked' => 'Questo IP è già bloccato.',
    'ip_not_found' => 'IP non trovato nella lista dei bloccati.',
    'ip_unblocked' => "L'IP è stato sbloccato.",

    'command' => [
        'domain_added' => "Dominio ':domain' aggiunto alla lista di blocco.",
        'domain_removed' => "Dominio ':domain' rimosso dalla lista di blocco.",
        'domain_already_blocked' => "Il dominio ':domain' è già bloccato.",
        'domain_not_found' => "Dominio ':domain' non trovato nella lista di blocco.",
        'domain_invalid' => 'Formato dominio non valido.',
        'no_custom_domains' => 'Nessun dominio personalizzato aggiunto.',
        'no_blocked_ips' => 'Nessun IP bloccato.',
        'ip_blocked_success' => "IP ':ip' è stato bloccato.",
        'ip_blocked_failed' => "Impossibile bloccare l'IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' è stato sbloccato.",
        'install_success' => 'Filament Security installato con successo!',
    ],

];

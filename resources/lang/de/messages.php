<?php

return [

    'disposable_email' => 'Einweg-E-Mail-Adressen sind nicht erlaubt.',
    'disposable_email_blocked' => 'Dieser E-Mail-Anbieter wird nicht akzeptiert. Bitte verwenden Sie eine permanente E-Mail-Adresse.',

    'dns_mx_suspicious' => 'Diese E-Mail-Domain scheint keine gültigen Mailserver zu haben. Bitte verwenden Sie eine gültige E-Mail-Adresse.',
    'domain_too_young' => 'Diese E-Mail-Domain wurde zu kürzlich registriert (mindestens :days Tage erforderlich). Bitte verwenden Sie einen etablierten E-Mail-Anbieter.',

    'session_terminated' => 'Ihre Sitzung wurde beendet, da Ihr Konto von einem anderen Gerät angemeldet wurde.',

    'honeypot_triggered' => 'Spam erkannt.',

    'ip_blocked' => 'Ihre IP wurde aufgrund verdächtiger Aktivitäten gesperrt.',
    'ip_blocked_reason_failed_login' => 'Zu viele fehlgeschlagene Anmeldeversuche.',
    'ip_blocked_reason_bot' => 'Bot erkannt (Honeypot ausgelöst).',
    'ip_blocked_reason_manual' => 'Manuelle Sperrung über CLI.',
    'ip_already_blocked' => 'Diese IP ist bereits gesperrt.',
    'ip_not_found' => 'IP nicht in der Sperrliste gefunden.',
    'ip_unblocked' => 'IP wurde entsperrt.',

    'command' => [
        'domain_added' => "Domain ':domain' zur Sperrliste hinzugefügt.",
        'domain_removed' => "Domain ':domain' aus der Sperrliste entfernt.",
        'domain_already_blocked' => "Domain ':domain' ist bereits gesperrt.",
        'domain_not_found' => "Domain ':domain' nicht in der Sperrliste gefunden.",
        'domain_invalid' => 'Ungültiges Domain-Format.',
        'no_custom_domains' => 'Keine benutzerdefinierten Domains hinzugefügt.',
        'no_blocked_ips' => 'Keine gesperrten IPs.',
        'ip_blocked_success' => "IP ':ip' wurde gesperrt.",
        'ip_blocked_failed' => "Fehler beim Sperren der IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' wurde entsperrt.",
        'install_success' => 'Filament Security erfolgreich installiert!',
    ],

];

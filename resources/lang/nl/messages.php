<?php

return [

    'disposable_email' => 'Wegwerp e-mailadressen zijn niet toegestaan.',
    'disposable_email_blocked' => 'Deze e-mailprovider wordt niet geaccepteerd. Gebruik alstublieft een permanent e-mailadres.',

    'dns_mx_suspicious' => 'Dit e-maildomein lijkt geen geldige mailservers te hebben. Gebruik alstublieft een geldig e-mailadres.',
    'domain_too_young' => 'Dit e-maildomein is te recent geregistreerd (minimaal :days dagen vereist). Gebruik alstublieft een gevestigde e-mailprovider.',

    'session_terminated' => 'Uw sessie is beëindigd omdat uw account is ingelogd vanaf een ander apparaat.',

    'honeypot_triggered' => 'Spam gedetecteerd.',

    'ip_blocked' => 'Uw IP is geblokkeerd vanwege verdachte activiteit.',
    'ip_blocked_reason_failed_login' => 'Te veel mislukte inlogpogingen.',
    'ip_blocked_reason_bot' => 'Bot gedetecteerd (honeypot geactiveerd).',
    'ip_blocked_reason_manual' => 'Handmatige blokkering via CLI.',
    'ip_already_blocked' => 'Dit IP is al geblokkeerd.',
    'ip_not_found' => 'IP niet gevonden in de blokkeerlijst.',
    'ip_unblocked' => 'IP is gedeblokkeerd.',

    'command' => [
        'domain_added' => "Domein ':domain' toegevoegd aan de blokkeerlijst.",
        'domain_removed' => "Domein ':domain' verwijderd uit de blokkeerlijst.",
        'domain_already_blocked' => "Domein ':domain' is al geblokkeerd.",
        'domain_not_found' => "Domein ':domain' niet gevonden in de blokkeerlijst.",
        'domain_invalid' => 'Ongeldig domeinformaat.',
        'no_custom_domains' => 'Nog geen aangepaste domeinen toegevoegd.',
        'no_blocked_ips' => "Geen geblokkeerde IP's.",
        'ip_blocked_success' => "IP ':ip' is geblokkeerd.",
        'ip_blocked_failed' => "Blokkering van IP ':ip' mislukt.",
        'ip_unblocked_success' => "IP ':ip' is gedeblokkeerd.",
        'install_success' => 'Filament Security succesvol geïnstalleerd!',
    ],

];

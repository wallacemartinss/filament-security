<?php

return [

    'disposable_email' => 'Les adresses e-mail jetables ne sont pas autorisées.',
    'disposable_email_blocked' => "Ce fournisseur d'e-mail n'est pas accepté. Veuillez utiliser une adresse e-mail permanente.",

    'dns_mx_suspicious' => 'Ce domaine e-mail ne semble pas avoir de serveurs de messagerie valides. Veuillez utiliser une adresse e-mail valide.',
    'domain_too_young' => "Ce domaine e-mail a été enregistré trop récemment (minimum :days jours requis). Veuillez utiliser un fournisseur d'e-mail établi.",

    'session_terminated' => 'Votre session a été terminée car votre compte a été connecté depuis un autre appareil.',

    'honeypot_triggered' => 'Spam détecté.',

    'ip_blocked' => 'Votre IP a été bloquée en raison d\'une activité suspecte.',
    'ip_blocked_reason_failed_login' => 'Trop de tentatives de connexion échouées.',
    'ip_blocked_reason_bot' => 'Bot détecté (honeypot déclenché).',
    'ip_blocked_reason_manual' => 'Blocage manuel via CLI.',
    'ip_already_blocked' => 'Cette IP est déjà bloquée.',
    'ip_not_found' => 'IP non trouvée dans la liste des bloquées.',
    'ip_unblocked' => "L'IP a été débloquée.",

    'command' => [
        'domain_added' => "Domaine ':domain' ajouté à la liste de blocage.",
        'domain_removed' => "Domaine ':domain' supprimé de la liste de blocage.",
        'domain_already_blocked' => "Le domaine ':domain' est déjà bloqué.",
        'domain_not_found' => "Domaine ':domain' non trouvé dans la liste de blocage.",
        'domain_invalid' => 'Format de domaine invalide.',
        'no_custom_domains' => 'Aucun domaine personnalisé ajouté.',
        'no_blocked_ips' => 'Aucune IP bloquée.',
        'ip_blocked_success' => "IP ':ip' a été bloquée.",
        'ip_blocked_failed' => "Échec du blocage de l'IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' a été débloquée.",
        'install_success' => 'Filament Security installé avec succès !',
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

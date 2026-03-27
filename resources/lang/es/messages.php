<?php

return [

    'disposable_email' => 'No se permiten direcciones de correo electrónico desechables.',
    'disposable_email_blocked' => 'Este proveedor de correo electrónico no es aceptado. Por favor, use una dirección de correo permanente.',

    'dns_mx_suspicious' => 'Este dominio de correo electrónico no parece tener servidores de correo válidos. Por favor, use una dirección de correo válida.',
    'domain_too_young' => 'Este dominio de correo fue registrado muy recientemente (mínimo :days días requeridos). Por favor, use un proveedor de correo establecido.',

    'session_terminated' => 'Su sesión fue terminada porque su cuenta inició sesión desde otro dispositivo.',

    'honeypot_triggered' => 'Spam detectado.',

    'ip_blocked' => 'Su IP ha sido bloqueada debido a actividad sospechosa.',
    'ip_blocked_reason_failed_login' => 'Demasiados intentos de inicio de sesión fallidos.',
    'ip_blocked_reason_bot' => 'Bot detectado (honeypot activado).',
    'ip_blocked_reason_manual' => 'Bloqueo manual vía CLI.',
    'ip_already_blocked' => 'Esta IP ya está bloqueada.',
    'ip_not_found' => 'IP no encontrada en la lista de bloqueados.',
    'ip_unblocked' => 'La IP ha sido desbloqueada.',

    'command' => [
        'domain_added' => "Dominio ':domain' añadido a la lista de bloqueo.",
        'domain_removed' => "Dominio ':domain' eliminado de la lista de bloqueo.",
        'domain_already_blocked' => "El dominio ':domain' ya está bloqueado.",
        'domain_not_found' => "Dominio ':domain' no encontrado en la lista de bloqueo.",
        'domain_invalid' => 'Formato de dominio inválido.',
        'no_custom_domains' => 'No se han añadido dominios personalizados.',
        'no_blocked_ips' => 'No hay IPs bloqueadas.',
        'ip_blocked_success' => "IP ':ip' ha sido bloqueada.",
        'ip_blocked_failed' => "Error al bloquear IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' ha sido desbloqueada.",
        'install_success' => '¡Filament Security instalado con éxito!',
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

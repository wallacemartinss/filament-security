<?php

return [

    'disposable_email' => 'No se permiten direcciones de correo electrónico desechables.',
    'disposable_email_blocked' => 'Este proveedor de correo electrónico no es aceptado. Por favor, use una dirección de correo permanente.',

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

];

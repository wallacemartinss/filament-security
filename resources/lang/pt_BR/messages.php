<?php

return [

    'disposable_email' => 'Endereços de email descartáveis não são permitidos.',
    'disposable_email_blocked' => 'Este provedor de email não é aceito. Por favor, use um endereço de email permanente.',

    'honeypot_triggered' => 'Spam detectado.',

    'ip_blocked' => 'Seu IP foi bloqueado devido a atividade suspeita.',
    'ip_blocked_reason_failed_login' => 'Muitas tentativas de login falharam.',
    'ip_blocked_reason_bot' => 'Bot detectado (honeypot acionado).',
    'ip_blocked_reason_manual' => 'Bloqueio manual via CLI.',
    'ip_already_blocked' => 'Este IP já está bloqueado.',
    'ip_not_found' => 'IP não encontrado na lista de bloqueados.',
    'ip_unblocked' => 'IP foi desbloqueado.',

    'command' => [
        'domain_added' => "Domínio ':domain' adicionado à lista de bloqueio.",
        'domain_removed' => "Domínio ':domain' removido da lista de bloqueio.",
        'domain_already_blocked' => "Domínio ':domain' já está bloqueado.",
        'domain_not_found' => "Domínio ':domain' não encontrado na lista de bloqueio.",
        'domain_invalid' => 'Formato de domínio inválido.',
        'no_custom_domains' => 'Nenhum domínio personalizado adicionado.',
        'no_blocked_ips' => 'Nenhum IP bloqueado.',
        'ip_blocked_success' => "IP ':ip' foi bloqueado.",
        'ip_blocked_failed' => "Falha ao bloquear IP ':ip'.",
        'ip_unblocked_success' => "IP ':ip' foi desbloqueado.",
        'install_success' => 'Filament Security instalado com sucesso!',
    ],

];

<?php

return [

    'disposable_email' => 'Endereços de email descartáveis não são permitidos.',
    'disposable_email_blocked' => 'Este provedor de email não é aceito. Por favor, use um endereço de email permanente.',

    'dns_mx_suspicious' => 'Este domínio de email não parece ter servidores de email válidos. Por favor, use um endereço de email válido.',
    'domain_too_young' => 'Este domínio de email foi registrado muito recentemente (mínimo de :days dias). Por favor, use um provedor de email estabelecido.',

    'session_terminated' => 'Sua sessão foi encerrada porque sua conta foi acessada em outro dispositivo.',

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

    'event_log' => [
        'navigation_group' => 'Sistema',
        'navigation_label' => 'Eventos de Segurança',
        'model_label' => 'Evento de Segurança',
        'plural_model_label' => 'Eventos de Segurança',
        'badge_tooltip' => 'Eventos hoje',
        'tabs' => [
            'email' => 'Email',
            'bot_scan' => 'Bots & Scans',
            'session' => 'Sessão',
            'auth' => 'Autenticação',
            'ip_management' => 'Gestão de IP',
        ],
        'table' => [
            'type' => 'Tipo',
            'location' => 'Localização',
            'domain' => 'Domínio',
            'trigger' => 'Gatilho',
            'count' => 'Contagem',
            'date' => 'Data',
        ],
        'stats' => [
            'events_today' => 'Eventos Hoje',
            'ips_blocked_today' => 'IPs Bloqueados Hoje',
            'auto_blocked' => 'Bloqueio automático',
            'top_threat' => 'Principal Ameaça (7d)',
            'unique_ips' => 'IPs Únicos (7d)',
        ],
        'charts' => [
            'threat_activity' => 'Atividade de Ameaças (14 dias)',
            'events_by_type' => 'Eventos por Tipo (7 dias)',
            'top_attackers' => 'IPs Mais Ofensivos (7 dias)',
            'no_threats' => 'Nenhuma ameaça detectada',
            'no_threats_description' => 'Nenhum evento de segurança nos últimos 7 dias.',
            'events' => 'Eventos',
            'types' => 'Tipos',
            'last_seen' => 'Última Atividade',
            'banned' => 'Banido',
            'active' => 'Ativo',
        ],
        'actions' => [
            'backfill_label' => 'Preencher Localizações (:count IPs)',
            'backfill_heading' => 'Preencher Localizações de IP',
            'backfill_description' => 'Enriquecer :count IPs únicos sem dados de localização via API IpInfo.',
            'backfill_submit' => 'Iniciar Preenchimento',
            'backfill_complete' => 'Preenchimento concluído',
            'backfill_result' => ':enriched IPs enriquecidos (:failed falhou/privado)',
            'ipinfo_not_configured' => 'IpInfo não configurado',
            'ipinfo_not_configured_body' => 'Defina IPINFO_TOKEN no seu arquivo .env.',
            'unban_label' => 'Desbanir IP',
            'unban_heading' => 'Desbanir Endereço IP',
            'unban_description' => 'Remover bloqueio do IP :ip?',
            'unban_success' => 'IP :ip desbanido',
        ],
    ],

];

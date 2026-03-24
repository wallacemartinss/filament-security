<?php

return [

    'disposable_email' => 'Les adresses e-mail jetables ne sont pas autorisées.',
    'disposable_email_blocked' => "Ce fournisseur d'e-mail n'est pas accepté. Veuillez utiliser une adresse e-mail permanente.",

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

];

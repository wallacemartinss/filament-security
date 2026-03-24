<?php

return [

    'disposable_email' => '使い捨てメールアドレスは許可されていません。',
    'disposable_email_blocked' => 'このメールプロバイダーは受け付けられません。恒久的なメールアドレスをご使用ください。',

    'honeypot_triggered' => 'スパムが検出されました。',

    'ip_blocked' => '不審な活動のため、IPがブロックされました。',
    'ip_blocked_reason_failed_login' => 'ログイン試行の失敗回数が多すぎます。',
    'ip_blocked_reason_bot' => 'ボットを検出しました（ハニーポット発動）。',
    'ip_blocked_reason_manual' => 'CLIによる手動ブロック。',
    'ip_already_blocked' => 'このIPは既にブロックされています。',
    'ip_not_found' => 'ブロックリストにIPが見つかりません。',
    'ip_unblocked' => 'IPのブロックが解除されました。',

    'command' => [
        'domain_added' => "ドメイン ':domain' をブロックリストに追加しました。",
        'domain_removed' => "ドメイン ':domain' をブロックリストから削除しました。",
        'domain_already_blocked' => "ドメイン ':domain' は既にブロックされています。",
        'domain_not_found' => "ドメイン ':domain' がブロックリストに見つかりません。",
        'domain_invalid' => '無効なドメイン形式です。',
        'no_custom_domains' => 'カスタムドメインはまだ追加されていません。',
        'no_blocked_ips' => 'ブロックされたIPはありません。',
        'ip_blocked_success' => "IP ':ip' をブロックしました。",
        'ip_blocked_failed' => "IP ':ip' のブロックに失敗しました。",
        'ip_unblocked_success' => "IP ':ip' のブロックを解除しました。",
        'install_success' => 'Filament Securityのインストールが完了しました！',
    ],

];

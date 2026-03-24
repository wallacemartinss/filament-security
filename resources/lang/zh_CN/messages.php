<?php

return [

    'disposable_email' => '不允许使用一次性电子邮件地址。',
    'disposable_email_blocked' => '此电子邮件提供商不被接受。请使用永久电子邮件地址。',

    'honeypot_triggered' => '检测到垃圾邮件。',

    'ip_blocked' => '由于可疑活动，您的IP已被封锁。',
    'ip_blocked_reason_failed_login' => '登录失败次数过多。',
    'ip_blocked_reason_bot' => '检测到机器人（蜜罐触发）。',
    'ip_blocked_reason_manual' => '通过CLI手动封锁。',
    'ip_already_blocked' => '此IP已被封锁。',
    'ip_not_found' => '在封锁列表中未找到此IP。',
    'ip_unblocked' => 'IP已解封。',

    'command' => [
        'domain_added' => "域名 ':domain' 已添加到封锁列表。",
        'domain_removed' => "域名 ':domain' 已从封锁列表中移除。",
        'domain_already_blocked' => "域名 ':domain' 已被封锁。",
        'domain_not_found' => "在封锁列表中未找到域名 ':domain'。",
        'domain_invalid' => '无效的域名格式。',
        'no_custom_domains' => '尚未添加自定义域名。',
        'no_blocked_ips' => '没有被封锁的IP。',
        'ip_blocked_success' => "IP ':ip' 已被封锁。",
        'ip_blocked_failed' => "封锁IP ':ip' 失败。",
        'ip_unblocked_success' => "IP ':ip' 已解封。",
        'install_success' => 'Filament Security 安装成功！',
    ],

];

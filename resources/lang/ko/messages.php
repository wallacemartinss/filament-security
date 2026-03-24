<?php

return [

    'disposable_email' => '일회용 이메일 주소는 허용되지 않습니다.',
    'disposable_email_blocked' => '이 이메일 제공업체는 허용되지 않습니다. 영구적인 이메일 주소를 사용해 주세요.',

    'honeypot_triggered' => '스팸이 감지되었습니다.',

    'ip_blocked' => '의심스러운 활동으로 인해 IP가 차단되었습니다.',
    'ip_blocked_reason_failed_login' => '로그인 시도 실패 횟수가 너무 많습니다.',
    'ip_blocked_reason_bot' => '봇이 감지되었습니다 (허니팟 작동).',
    'ip_blocked_reason_manual' => 'CLI를 통한 수동 차단.',
    'ip_already_blocked' => '이 IP는 이미 차단되어 있습니다.',
    'ip_not_found' => '차단 목록에서 IP를 찾을 수 없습니다.',
    'ip_unblocked' => 'IP 차단이 해제되었습니다.',

    'command' => [
        'domain_added' => "도메인 ':domain'이(가) 차단 목록에 추가되었습니다.",
        'domain_removed' => "도메인 ':domain'이(가) 차단 목록에서 제거되었습니다.",
        'domain_already_blocked' => "도메인 ':domain'은(는) 이미 차단되어 있습니다.",
        'domain_not_found' => "차단 목록에서 도메인 ':domain'을(를) 찾을 수 없습니다.",
        'domain_invalid' => '잘못된 도메인 형식입니다.',
        'no_custom_domains' => '추가된 사용자 정의 도메인이 없습니다.',
        'no_blocked_ips' => '차단된 IP가 없습니다.',
        'ip_blocked_success' => "IP ':ip'이(가) 차단되었습니다.",
        'ip_blocked_failed' => "IP ':ip' 차단에 실패했습니다.",
        'ip_unblocked_success' => "IP ':ip' 차단이 해제되었습니다.",
        'install_success' => 'Filament Security가 성공적으로 설치되었습니다!',
    ],

];

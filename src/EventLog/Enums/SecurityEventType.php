<?php

namespace WallaceMartinss\FilamentSecurity\EventLog\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SecurityEventType: string implements HasColor, HasIcon, HasLabel
{
    // Email (Layer 1, 2, 3)
    case DisposableEmail = 'disposable_email';
    case DnsMxSuspicious = 'dns_mx_suspicious';
    case DomainTooYoung = 'domain_too_young';

    // Session (Layer 4)
    case SessionTerminated = 'session_terminated';

    // Bot & Scans (Layer 5, 7)
    case HoneypotTriggered = 'honeypot_triggered';
    case MaliciousScan = 'malicious_scan';

    // Auth (Layer 6)
    case LoginLockout = 'login_lockout';

    // IP Management (Layer 6)
    case IpBlocked = 'ip_blocked';
    case IpUnblocked = 'ip_unblocked';

    public function getLabel(): string
    {
        return match ($this) {
            self::DisposableEmail => 'Disposable Email',
            self::DnsMxSuspicious => 'DNS/MX Suspicious',
            self::DomainTooYoung => 'Domain Too Young',
            self::SessionTerminated => 'Session Terminated',
            self::HoneypotTriggered => 'Honeypot Triggered',
            self::MaliciousScan => 'Malicious Scan',
            self::LoginLockout => 'Login Lockout',
            self::IpBlocked => 'IP Blocked',
            self::IpUnblocked => 'IP Unblocked',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DisposableEmail => 'warning',
            self::DnsMxSuspicious => 'warning',
            self::DomainTooYoung => 'warning',
            self::SessionTerminated => 'info',
            self::HoneypotTriggered => 'danger',
            self::MaliciousScan => 'danger',
            self::LoginLockout => 'danger',
            self::IpBlocked => 'danger',
            self::IpUnblocked => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::DisposableEmail => 'heroicon-o-envelope',
            self::DnsMxSuspicious => 'heroicon-o-server',
            self::DomainTooYoung => 'heroicon-o-clock',
            self::SessionTerminated => 'heroicon-o-arrow-right-on-rectangle',
            self::HoneypotTriggered => 'heroicon-o-bug-ant',
            self::MaliciousScan => 'heroicon-o-magnifying-glass-circle',
            self::LoginLockout => 'heroicon-o-lock-closed',
            self::IpBlocked => 'heroicon-o-shield-exclamation',
            self::IpUnblocked => 'heroicon-o-shield-check',
        };
    }

    public function getCategory(): string
    {
        return match ($this) {
            self::DisposableEmail, self::DnsMxSuspicious, self::DomainTooYoung => 'email',
            self::SessionTerminated => 'session',
            self::HoneypotTriggered, self::MaliciousScan => 'bot_scan',
            self::LoginLockout => 'auth',
            self::IpBlocked, self::IpUnblocked => 'ip_management',
        };
    }

    /**
     * @return array<self>
     */
    public static function byCategory(string $category): array
    {
        return array_filter(self::cases(), fn (self $case) => $case->getCategory() === $category);
    }

    /**
     * @return array<string>
     */
    public static function valuesByCategory(string $category): array
    {
        return array_map(fn (self $case) => $case->value, self::byCategory($category));
    }
}

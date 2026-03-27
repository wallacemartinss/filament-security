<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DnsVerificationService;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class DnsMxRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (DnsVerificationService::isSuspicious($value)) {
            $domain = str_contains($value, '@') ? explode('@', $value, 2)[1] : null;

            SecurityEvent::record(SecurityEventType::DnsMxSuspicious->value, [
                'email' => $value,
                'domain' => $domain,
            ]);

            $fail(__('filament-security::messages.dns_mx_suspicious'));
        }
    }
}

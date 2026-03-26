<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DnsVerificationService;

class DnsMxRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (DnsVerificationService::isSuspicious($value)) {
            $fail(__('filament-security::messages.dns_mx_suspicious'));
        }
    }
}

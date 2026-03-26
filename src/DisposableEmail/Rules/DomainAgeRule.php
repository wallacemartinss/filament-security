<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\RdapService;

class DomainAgeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (RdapService::isDomainTooYoung($value)) {
            $minDays = (int) config('filament-security.domain_age.min_days', 30);

            $fail(__('filament-security::messages.domain_too_young', [
                'days' => $minDays,
            ]));
        }
    }
}

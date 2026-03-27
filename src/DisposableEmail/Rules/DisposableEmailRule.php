<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class DisposableEmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (DisposableEmailService::isDisposable($value)) {
            $domain = str_contains($value, '@') ? explode('@', $value, 2)[1] : null;

            SecurityEvent::record(SecurityEventType::DisposableEmail->value, [
                'email' => $value,
                'domain' => $domain,
            ]);

            $fail(__('filament-security::messages.disposable_email'));
        }
    }
}

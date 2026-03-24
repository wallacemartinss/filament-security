<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;

class DisposableEmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (DisposableEmailService::isDisposable($value)) {
            $fail(__('filament-security::messages.disposable_email'));
        }
    }
}

<?php

namespace WallaceMartinss\FilamentSecurity\Auth\Concerns;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DisposableEmailRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DnsMxRule;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DomainAgeRule;

trait HasDisposableEmailProtection
{
    protected function getEmailFormComponent(): Component
    {
        $component = TextInput::make('email')
            ->label(__('filament-panels::auth/pages/register.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel());

        $rules = [];

        if (config('filament-security.disposable_email.enabled', true)) {
            $rules[] = new DisposableEmailRule;
        }

        if (config('filament-security.dns_verification.enabled', true)) {
            $rules[] = new DnsMxRule;
        }

        if (config('filament-security.domain_age.enabled', false)) {
            $rules[] = new DomainAgeRule;
        }

        if (! empty($rules)) {
            $component->rules($rules);
        }

        return $component;
    }
}

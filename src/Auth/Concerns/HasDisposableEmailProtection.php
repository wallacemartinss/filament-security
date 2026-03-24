<?php

namespace WallaceMartinss\FilamentSecurity\Auth\Concerns;

use Filament\Schemas\Components\Component;
use Filament\Forms\Components\TextInput;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DisposableEmailRule;

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

        if (config('filament-security.disposable_email.enabled', true)) {
            $component->rules([new DisposableEmailRule]);
        }

        return $component;
    }
}

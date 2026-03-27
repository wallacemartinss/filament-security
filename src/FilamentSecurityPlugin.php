<?php

namespace WallaceMartinss\FilamentSecurity;

use Filament\Auth\Pages\Register;
use Filament\Contracts\Plugin;
use Filament\Panel;
use WallaceMartinss\FilamentSecurity\Auth\FilamentSecurityRegister;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource;

class FilamentSecurityPlugin implements Plugin
{
    protected bool $hasDisposableEmailProtection = true;

    protected bool $hasHoneypotProtection = true;

    protected bool $hasCloudflareBlocking = false;

    protected bool $hasSingleSession = false;

    protected bool $hasEventLog = false;

    protected bool $hasMaliciousScanProtection = false;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'filament-security';
    }

    public function register(Panel $panel): void
    {
        if ($this->hasDisposableEmailProtection() || $this->hasHoneypotProtection()) {
            $this->registerSecureRegistrationPage($panel);
        }

        if ($this->hasEventLog()) {
            $panel->resources([
                SecurityEventResource::class,
            ]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    protected function registerSecureRegistrationPage(Panel $panel): void
    {
        if (! $panel->hasRegistration()) {
            return;
        }

        $currentAction = $panel->getRegistrationRouteAction();

        if ($currentAction === Register::class) {
            $panel->registration(FilamentSecurityRegister::class);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Feature Toggles
    |--------------------------------------------------------------------------
    */

    public function disposableEmailProtection(bool $condition = true): static
    {
        $this->hasDisposableEmailProtection = $condition;

        return $this;
    }

    public function honeypotProtection(bool $condition = true): static
    {
        $this->hasHoneypotProtection = $condition;

        return $this;
    }

    public function cloudflareBlocking(bool $condition = true): static
    {
        $this->hasCloudflareBlocking = $condition;

        return $this;
    }

    public function singleSession(bool $condition = true): static
    {
        $this->hasSingleSession = $condition;

        return $this;
    }

    public function eventLog(bool $condition = true): static
    {
        $this->hasEventLog = $condition;

        return $this;
    }

    public function maliciousScanProtection(bool $condition = true): static
    {
        $this->hasMaliciousScanProtection = $condition;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function hasDisposableEmailProtection(): bool
    {
        return $this->hasDisposableEmailProtection && config('filament-security.disposable_email.enabled', true);
    }

    public function hasHoneypotProtection(): bool
    {
        return $this->hasHoneypotProtection && config('filament-security.honeypot.enabled', true);
    }

    public function hasCloudflareBlocking(): bool
    {
        return $this->hasCloudflareBlocking && config('filament-security.cloudflare.enabled', false);
    }

    public function hasSingleSession(): bool
    {
        return $this->hasSingleSession && config('filament-security.single_session.enabled', false);
    }

    public function hasEventLog(): bool
    {
        return $this->hasEventLog && config('filament-security.event_log.enabled', false);
    }

    public function hasMaliciousScanProtection(): bool
    {
        return $this->hasMaliciousScanProtection && config('filament-security.malicious_scan.enabled', false);
    }
}

<?php

namespace WallaceMartinss\FilamentSecurity;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Event;
use Spatie\Honeypot\Events\SpamDetectedEvent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\CloudflareService;
use WallaceMartinss\FilamentSecurity\Listeners\HandleFailedLogin;
use WallaceMartinss\FilamentSecurity\Listeners\HandleSpamDetected;

class FilamentSecurityServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-security')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2026_01_01_000001_create_security_blocked_ips_table',
            ]);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(CloudflareService::class);
        $this->app->singleton(BlockIpService::class);
    }

    public function packageBooted(): void
    {
        $this->registerCommands();
        $this->registerEventListeners();
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class,
                Commands\AddDisposableDomainCommand::class,
                Commands\ManageBlockedIpsCommand::class,
            ]);
        }
    }

    protected function registerEventListeners(): void
    {
        if (! config('filament-security.cloudflare.enabled', false)) {
            return;
        }

        Event::listen(Failed::class, HandleFailedLogin::class);
        Event::listen(SpamDetectedEvent::class, HandleSpamDetected::class);
    }
}

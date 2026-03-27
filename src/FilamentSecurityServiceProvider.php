<?php

namespace WallaceMartinss\FilamentSecurity;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Spatie\Honeypot\Events\SpamDetectedEvent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\CloudflareService;
use WallaceMartinss\FilamentSecurity\Listeners\HandleFailedLogin;
use WallaceMartinss\FilamentSecurity\Listeners\HandleLogout;
use WallaceMartinss\FilamentSecurity\Listeners\HandleSpamDetected;
use WallaceMartinss\FilamentSecurity\Listeners\HandleSuccessfulLogin;
use WallaceMartinss\FilamentSecurity\Middleware\BlockMaliciousScans;
use WallaceMartinss\FilamentSecurity\SingleSession\SingleSessionMiddleware;

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
                '2026_01_01_000002_create_security_events_table',
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
        $this->registerSingleSessionMiddleware();
        $this->registerMaliciousScanMiddleware();
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
        $cloudflareOrEventLog = config('filament-security.cloudflare.enabled', false)
            || config('filament-security.event_log.enabled', false);

        if ($cloudflareOrEventLog) {
            Event::listen(Failed::class, HandleFailedLogin::class);
            Event::listen(SpamDetectedEvent::class, HandleSpamDetected::class);
        }

        if (config('filament-security.single_session.enabled', false)) {
            Event::listen(Login::class, HandleSuccessfulLogin::class);
            Event::listen(Logout::class, HandleLogout::class);
        }
    }

    protected function registerSingleSessionMiddleware(): void
    {
        if (! config('filament-security.single_session.enabled', false)) {
            return;
        }

        $this->app['router']->pushMiddlewareToGroup('web', SingleSessionMiddleware::class);
    }

    protected function registerMaliciousScanMiddleware(): void
    {
        if (! config('filament-security.malicious_scan.enabled', false)) {
            return;
        }

        // Must be global middleware (not web group) to intercept
        // requests to non-existent routes (wp-admin, .env, etc.)
        $this->app->make(\Illuminate\Contracts\Http\Kernel::class)
            ->pushMiddleware(BlockMaliciousScans::class);
    }
}

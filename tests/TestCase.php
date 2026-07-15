<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Honeypot\HoneypotServiceProvider;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;
use WallaceMartinss\FilamentSecurity\FilamentSecurityServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.disposable_email.enabled', true);
        config()->set('filament-security.disposable_email.cache_enabled', false);
        config()->set('filament-security.disposable_email.custom_domains', []);
        config()->set('filament-security.disposable_email.whitelisted_domains', []);

        DisposableEmailService::clearCache();
        $this->cleanCustomDomains();
    }

    protected function tearDown(): void
    {
        $this->cleanCustomDomains();

        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            HoneypotServiceProvider::class,
            FilamentSecurityServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Honeypot encrypts a timestamp, which needs an app key; Testbench sets none.
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function cleanCustomDomains(): void
    {
        $path = storage_path('filament-security/custom-domains.txt');

        if (file_exists($path)) {
            unlink($path);
        }
    }
}

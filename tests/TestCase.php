<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;

abstract class TestCase extends BaseTestCase
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

    protected function cleanCustomDomains(): void
    {
        $path = storage_path('filament-security/custom-domains.txt');

        if (file_exists($path)) {
            unlink($path);
        }
    }
}

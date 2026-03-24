<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\Cloudflare\CloudflareService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class CloudflareServiceTest extends TestCase
{
    #[Test]
    public function it_reports_not_configured_when_credentials_missing(): void
    {
        config()->set('filament-security.cloudflare.api_token', null);
        config()->set('filament-security.cloudflare.zone_id', null);

        $service = new CloudflareService;

        $this->assertFalse($service->isConfigured());
    }

    #[Test]
    public function it_reports_configured_when_credentials_present(): void
    {
        config()->set('filament-security.cloudflare.api_token', 'test-token');
        config()->set('filament-security.cloudflare.zone_id', 'test-zone');

        $service = new CloudflareService;

        $this->assertTrue($service->isConfigured());
    }

    #[Test]
    public function it_returns_null_when_blocking_without_config(): void
    {
        config()->set('filament-security.cloudflare.api_token', null);
        config()->set('filament-security.cloudflare.zone_id', null);

        $service = new CloudflareService;
        $result = $service->blockIp('192.0.2.1', 'Test');

        $this->assertNull($result);
    }

    #[Test]
    public function it_returns_false_when_unblocking_without_config(): void
    {
        config()->set('filament-security.cloudflare.api_token', null);
        config()->set('filament-security.cloudflare.zone_id', null);

        $service = new CloudflareService;

        $this->assertFalse($service->unblockIp('fake-rule-id'));
    }

    #[Test]
    public function it_returns_null_when_listing_without_config(): void
    {
        config()->set('filament-security.cloudflare.api_token', null);
        config()->set('filament-security.cloudflare.zone_id', null);

        $service = new CloudflareService;

        $this->assertNull($service->listBlockedIps());
    }
}

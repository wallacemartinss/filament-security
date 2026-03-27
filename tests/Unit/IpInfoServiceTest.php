<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\EventLog\Services\IpInfoService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class IpInfoServiceTest extends TestCase
{
    #[Test]
    public function it_reports_not_configured_without_token(): void
    {
        config()->set('filament-security.ipinfo.token', '');

        $service = new IpInfoService;

        $this->assertFalse($service->isConfigured());
    }

    #[Test]
    public function it_reports_configured_with_token(): void
    {
        config()->set('filament-security.ipinfo.token', 'test-token');

        $service = new IpInfoService;

        $this->assertTrue($service->isConfigured());
    }

    #[Test]
    public function it_returns_null_without_token(): void
    {
        config()->set('filament-security.ipinfo.token', '');

        $service = new IpInfoService;

        $this->assertNull($service->getIpInfo('8.8.8.8'));
    }

    #[Test]
    public function it_returns_null_for_private_ips(): void
    {
        config()->set('filament-security.ipinfo.token', 'test-token');

        $service = new IpInfoService;

        $this->assertNull($service->getIpInfo('192.168.1.1'));
        $this->assertNull($service->getIpInfo('10.0.0.1'));
        $this->assertNull($service->getIpInfo('127.0.0.1'));
    }

    #[Test]
    public function it_returns_null_for_loopback_address(): void
    {
        config()->set('filament-security.ipinfo.token', 'test-token');

        $service = new IpInfoService;

        $this->assertNull($service->getIpInfo('127.0.0.1'));
    }
}

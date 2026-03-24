<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\CloudflareService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class ManageBlockedIpsCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.cloudflare.enabled', true);
    }

    #[Test]
    public function it_shows_status(): void
    {
        $this->artisan('filament-security:blocked-ips', ['action' => 'status'])
            ->assertSuccessful();
    }

    #[Test]
    public function it_lists_empty_blocked_ips(): void
    {
        $this->artisan('filament-security:blocked-ips', ['action' => 'list'])
            ->assertSuccessful();
    }

    #[Test]
    public function it_blocks_an_ip_via_command(): void
    {
        $this->artisan('filament-security:blocked-ips', [
            'action' => 'block',
            'ip' => '192.0.2.100',
            '--reason' => 'CLI test',
        ])
            ->assertSuccessful();

        $this->assertDatabaseHas('security_blocked_ips', [
            'ip_address' => '192.0.2.100',
        ]);
    }

    #[Test]
    public function it_unblocks_an_ip_via_command(): void
    {
        $service = new BlockIpService(new CloudflareService);
        $service->blockIp('192.0.2.101', 'To unblock');

        $this->artisan('filament-security:blocked-ips', [
            'action' => 'unblock',
            'ip' => '192.0.2.101',
            '--force' => true,
        ])
            ->assertSuccessful();
    }

    #[Test]
    public function it_fails_for_invalid_action(): void
    {
        $this->artisan('filament-security:blocked-ips', ['action' => 'invalid'])
            ->assertFailed();
    }
}

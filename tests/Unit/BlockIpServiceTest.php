<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\CloudflareService;
use WallaceMartinss\FilamentSecurity\Models\BlockedIp;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class BlockIpServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BlockIpService $service;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.cloudflare.enabled', true);
        config()->set('filament-security.cloudflare.api_token', null);
        config()->set('filament-security.cloudflare.zone_id', null);
        config()->set('filament-security.cloudflare.max_attempts', 3);
        config()->set('filament-security.cloudflare.decay_minutes', 30);

        $this->service = new BlockIpService(new CloudflareService);
    }

    #[Test]
    public function it_blocks_an_ip_and_logs_to_database(): void
    {
        $this->service->blockIp('192.0.2.1', 'Test block');

        $this->assertDatabaseHas('security_blocked_ips', [
            'ip_address' => '192.0.2.1',
            'reason' => 'Test block',
        ]);
    }

    #[Test]
    public function it_does_not_double_block_same_ip(): void
    {
        $this->service->blockIp('192.0.2.2', 'First block');
        $this->service->blockIp('192.0.2.2', 'Second block');

        $this->assertEquals(1, BlockedIp::where('ip_address', '192.0.2.2')->active()->count());
    }

    #[Test]
    public function it_unblocks_an_ip(): void
    {
        $this->service->blockIp('192.0.2.3', 'To unblock');
        $this->service->unblockIp('192.0.2.3');

        $blocked = BlockedIp::where('ip_address', '192.0.2.3')->first();
        $this->assertNotNull($blocked->unblocked_at);
    }

    #[Test]
    public function it_returns_false_unblocking_unknown_ip(): void
    {
        $result = $this->service->unblockIp('10.0.0.99');

        $this->assertFalse($result);
    }

    #[Test]
    public function it_detects_already_blocked_ip(): void
    {
        $this->service->blockIp('192.0.2.4', 'Blocked');

        $this->assertTrue($this->service->isAlreadyBlocked('192.0.2.4'));
        $this->assertFalse($this->service->isAlreadyBlocked('192.0.2.5'));
    }

    #[Test]
    public function it_does_nothing_when_cloudflare_disabled(): void
    {
        config()->set('filament-security.cloudflare.enabled', false);

        $result = $this->service->blockIp('192.0.2.6', 'Should not block');

        $this->assertFalse($result);
        $this->assertDatabaseMissing('security_blocked_ips', [
            'ip_address' => '192.0.2.6',
        ]);
    }

    #[Test]
    public function it_blocks_after_max_attempts_exceeded(): void
    {
        // Max attempts is 3
        $this->service->recordFailedAttempt('192.0.2.10', 'Attempt 1');
        $this->service->recordFailedAttempt('192.0.2.10', 'Attempt 2');
        $this->service->recordFailedAttempt('192.0.2.10', 'Attempt 3');

        $this->assertFalse($this->service->isAlreadyBlocked('192.0.2.10'));

        // 4th attempt should trigger block
        $this->service->recordFailedAttempt('192.0.2.10', 'Attempt 4');

        $this->assertTrue($this->service->isAlreadyBlocked('192.0.2.10'));
    }
}

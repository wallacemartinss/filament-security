<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class SecurityEventTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.event_log.enabled', true);
        config()->set('filament-security.ipinfo.token', '');
    }

    #[Test]
    public function it_records_an_event_when_enabled(): void
    {
        $event = SecurityEvent::record(SecurityEventType::DisposableEmail->value, [
            'email' => 'test@mailinator.com',
            'domain' => 'mailinator.com',
        ]);

        $this->assertNotNull($event);
        $this->assertDatabaseHas('security_events', [
            'type' => 'disposable_email',
            'email' => 'test@mailinator.com',
            'domain' => 'mailinator.com',
        ]);
    }

    #[Test]
    public function it_returns_null_when_disabled(): void
    {
        config()->set('filament-security.event_log.enabled', false);

        $event = SecurityEvent::record(SecurityEventType::DisposableEmail->value, [
            'email' => 'test@mailinator.com',
        ]);

        $this->assertNull($event);
        $this->assertDatabaseCount('security_events', 0);
    }

    #[Test]
    public function it_uses_uuid_as_primary_key(): void
    {
        $event = SecurityEvent::record(SecurityEventType::MaliciousScan->value);

        $this->assertNotNull($event);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $event->id,
        );
    }

    #[Test]
    public function it_stores_metadata_as_json(): void
    {
        $event = SecurityEvent::record(SecurityEventType::LoginLockout->value, [
            'metadata' => ['attempts' => 5, 'window' => 30],
        ]);

        $this->assertNotNull($event);
        $fresh = $event->fresh();
        $this->assertIsArray($fresh->metadata);
        $this->assertSame(5, $fresh->metadata['attempts']);
    }

    #[Test]
    public function it_records_all_event_types(): void
    {
        foreach (SecurityEventType::cases() as $type) {
            SecurityEvent::record($type->value, [
                'ip_address' => '127.0.0.1',
            ]);
        }

        $this->assertDatabaseCount('security_events', count(SecurityEventType::cases()));
    }

    #[Test]
    public function it_captures_request_data_automatically(): void
    {
        $event = SecurityEvent::record(SecurityEventType::HoneypotTriggered->value);

        $this->assertNotNull($event);
        $this->assertNotNull($event->path);
    }

    #[Test]
    public function it_allows_overriding_ip_address(): void
    {
        $event = SecurityEvent::record(SecurityEventType::MaliciousScan->value, [
            'ip_address' => '203.0.113.50',
        ]);

        $this->assertNotNull($event);
        $this->assertSame('203.0.113.50', $event->ip_address);
    }
}

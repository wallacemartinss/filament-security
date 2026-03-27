<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class SecurityEventTypeTest extends TestCase
{
    #[Test]
    public function it_has_nine_event_types(): void
    {
        $this->assertCount(9, SecurityEventType::cases());
    }

    #[Test]
    public function all_types_have_labels(): void
    {
        foreach (SecurityEventType::cases() as $type) {
            $this->assertNotEmpty($type->getLabel());
        }
    }

    #[Test]
    public function all_types_have_colors(): void
    {
        foreach (SecurityEventType::cases() as $type) {
            $this->assertNotEmpty($type->getColor());
        }
    }

    #[Test]
    public function all_types_have_icons(): void
    {
        foreach (SecurityEventType::cases() as $type) {
            $this->assertStringStartsWith('heroicon-', $type->getIcon());
        }
    }

    #[Test]
    public function all_types_have_categories(): void
    {
        $validCategories = ['email', 'session', 'bot_scan', 'auth', 'ip_management'];

        foreach (SecurityEventType::cases() as $type) {
            $this->assertContains($type->getCategory(), $validCategories);
        }
    }

    #[Test]
    public function it_filters_by_category(): void
    {
        $emailTypes = SecurityEventType::byCategory('email');

        $this->assertCount(3, $emailTypes);
        $this->assertContains(SecurityEventType::DisposableEmail, $emailTypes);
        $this->assertContains(SecurityEventType::DnsMxSuspicious, $emailTypes);
        $this->assertContains(SecurityEventType::DomainTooYoung, $emailTypes);
    }

    #[Test]
    public function it_returns_values_by_category(): void
    {
        $botValues = SecurityEventType::valuesByCategory('bot_scan');

        $this->assertContains('honeypot_triggered', $botValues);
        $this->assertContains('malicious_scan', $botValues);
    }

    #[Test]
    public function it_returns_empty_for_unknown_category(): void
    {
        $this->assertEmpty(SecurityEventType::byCategory('nonexistent'));
    }

    #[Test]
    public function ip_management_category_has_two_types(): void
    {
        $ipTypes = SecurityEventType::byCategory('ip_management');

        $this->assertCount(2, $ipTypes);
    }

    #[Test]
    public function session_category_has_one_type(): void
    {
        $sessionTypes = SecurityEventType::byCategory('session');

        $this->assertCount(1, $sessionTypes);
        $this->assertContains(SecurityEventType::SessionTerminated, $sessionTypes);
    }
}

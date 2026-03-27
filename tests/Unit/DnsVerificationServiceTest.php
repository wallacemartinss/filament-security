<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DnsVerificationService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class DnsVerificationServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.dns_verification.enabled', true);
        config()->set('filament-security.dns_verification.cache_enabled', false);
    }

    #[Test]
    public function it_allows_emails_with_valid_mx_records(): void
    {
        $this->assertFalse(DnsVerificationService::isSuspicious('user@gmail.com'));
    }

    #[Test]
    public function it_allows_emails_with_valid_mx_from_major_providers(): void
    {
        $this->assertFalse(DnsVerificationService::isSuspicious('user@outlook.com'));
        $this->assertFalse(DnsVerificationService::isSuspicious('user@yahoo.com'));
    }

    #[Test]
    public function it_detects_domains_with_no_dns_records(): void
    {
        $this->assertTrue(DnsVerificationService::isSuspicious('user@this-domain-does-not-exist-xyz-12345.com'));
    }

    #[Test]
    public function it_returns_false_for_emails_without_at_sign(): void
    {
        $this->assertFalse(DnsVerificationService::isSuspicious('invalidemail'));
    }

    #[Test]
    public function it_handles_empty_strings(): void
    {
        $this->assertFalse(DnsVerificationService::isSuspicious(''));
    }

    #[Test]
    public function it_is_case_insensitive(): void
    {
        $this->assertFalse(DnsVerificationService::isSuspicious('User@Gmail.COM'));
    }

    #[Test]
    public function it_can_check_domain_directly(): void
    {
        $this->assertFalse(DnsVerificationService::isDomainSuspicious('gmail.com'));
        $this->assertTrue(DnsVerificationService::isDomainSuspicious('this-domain-does-not-exist-xyz-12345.com'));
    }
}

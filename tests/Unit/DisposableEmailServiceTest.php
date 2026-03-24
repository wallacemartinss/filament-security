<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class DisposableEmailServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DisposableEmailService::clearCache();
    }

    #[Test]
    public function it_detects_known_disposable_emails(): void
    {
        $this->assertTrue(DisposableEmailService::isDisposable('user@mailinator.com'));
        $this->assertTrue(DisposableEmailService::isDisposable('user@yopmail.com'));
        $this->assertTrue(DisposableEmailService::isDisposable('user@guerrillamail.com'));
        $this->assertTrue(DisposableEmailService::isDisposable('user@temp-mail.com'));
        $this->assertTrue(DisposableEmailService::isDisposable('user@sharklasers.com'));
    }

    #[Test]
    public function it_allows_legitimate_emails(): void
    {
        $this->assertFalse(DisposableEmailService::isDisposable('user@gmail.com'));
        $this->assertFalse(DisposableEmailService::isDisposable('user@hotmail.com'));
        $this->assertFalse(DisposableEmailService::isDisposable('user@outlook.com'));
        $this->assertFalse(DisposableEmailService::isDisposable('user@yahoo.com'));
        $this->assertFalse(DisposableEmailService::isDisposable('user@protonmail.com'));
    }

    #[Test]
    public function it_handles_case_insensitive_emails(): void
    {
        $this->assertTrue(DisposableEmailService::isDisposable('User@MAILINATOR.COM'));
        $this->assertTrue(DisposableEmailService::isDisposable('TEST@Yopmail.Com'));
        $this->assertFalse(DisposableEmailService::isDisposable('USER@GMAIL.COM'));
    }

    #[Test]
    public function it_handles_emails_with_whitespace(): void
    {
        $this->assertTrue(DisposableEmailService::isDisposable('  user@mailinator.com  '));
        $this->assertFalse(DisposableEmailService::isDisposable('  user@gmail.com  '));
    }

    #[Test]
    public function it_returns_false_for_invalid_emails(): void
    {
        $this->assertFalse(DisposableEmailService::isDisposable('notanemail'));
        $this->assertFalse(DisposableEmailService::isDisposable(''));
        $this->assertFalse(DisposableEmailService::isDisposable('missing-at-sign.com'));
    }

    #[Test]
    public function it_loads_built_in_domains(): void
    {
        $domains = DisposableEmailService::getAllDomains();

        $this->assertIsArray($domains);
        $this->assertGreaterThan(3000, count($domains));
        $this->assertContains('mailinator.com', $domains);
        $this->assertContains('yopmail.com', $domains);
    }

    #[Test]
    public function it_adds_custom_domain(): void
    {
        $result = DisposableEmailService::addDomain('my-custom-spam.com');

        $this->assertTrue($result);
        $this->assertTrue(DisposableEmailService::isDisposable('test@my-custom-spam.com'));
    }

    #[Test]
    public function it_prevents_duplicate_custom_domain(): void
    {
        DisposableEmailService::addDomain('duplicate-test.com');
        DisposableEmailService::clearCache();

        $result = DisposableEmailService::addDomain('duplicate-test.com');

        $this->assertFalse($result);
    }

    #[Test]
    public function it_rejects_invalid_domain_format(): void
    {
        $this->assertFalse(DisposableEmailService::addDomain('not a domain'));
        $this->assertFalse(DisposableEmailService::addDomain('missing-tld'));
        $this->assertFalse(DisposableEmailService::addDomain('@nodomain'));
        $this->assertFalse(DisposableEmailService::addDomain(''));
    }

    #[Test]
    public function it_removes_custom_domain(): void
    {
        DisposableEmailService::addDomain('to-remove.com');
        DisposableEmailService::clearCache();

        $this->assertTrue(DisposableEmailService::isDisposable('test@to-remove.com'));

        DisposableEmailService::removeDomain('to-remove.com');
        DisposableEmailService::clearCache();

        $this->assertFalse(DisposableEmailService::isDisposable('test@to-remove.com'));
    }

    #[Test]
    public function it_returns_false_when_removing_nonexistent_domain(): void
    {
        $result = DisposableEmailService::removeDomain('never-added.com');

        $this->assertFalse($result);
    }

    #[Test]
    public function it_respects_whitelisted_domains(): void
    {
        config()->set('filament-security.disposable_email.whitelisted_domains', [
            'mailinator.com',
        ]);

        DisposableEmailService::clearCache();

        $this->assertFalse(DisposableEmailService::isDisposable('test@mailinator.com'));
    }

    #[Test]
    public function it_includes_config_custom_domains(): void
    {
        config()->set('filament-security.disposable_email.custom_domains', [
            'config-blocked.com',
        ]);

        DisposableEmailService::clearCache();

        $this->assertTrue(DisposableEmailService::isDisposable('test@config-blocked.com'));
    }

    #[Test]
    public function it_returns_correct_stats(): void
    {
        DisposableEmailService::addDomain('stats-test.com');
        DisposableEmailService::clearCache();

        config()->set('filament-security.disposable_email.custom_domains', ['config-test.com']);
        config()->set('filament-security.disposable_email.whitelisted_domains', ['whitelisted.com']);

        $stats = DisposableEmailService::getStats();

        $this->assertArrayHasKey('built_in', $stats);
        $this->assertArrayHasKey('custom_file', $stats);
        $this->assertArrayHasKey('config', $stats);
        $this->assertArrayHasKey('whitelisted', $stats);
        $this->assertArrayHasKey('total', $stats);
        $this->assertGreaterThan(3000, $stats['built_in']);
        $this->assertEquals(1, $stats['custom_file']);
        $this->assertEquals(1, $stats['config']);
        $this->assertEquals(1, $stats['whitelisted']);
    }

    #[Test]
    public function it_ignores_comments_in_custom_domains_file(): void
    {
        $directory = storage_path('filament-security');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(
            storage_path('filament-security/custom-domains.txt'),
            "# This is a comment\nvalid-domain.com\n# Another comment\n"
        );

        DisposableEmailService::clearCache();

        $this->assertTrue(DisposableEmailService::isDisposable('test@valid-domain.com'));
        $this->assertFalse(DisposableEmailService::isDisposable('test@this-is-a-comment'));
    }
}

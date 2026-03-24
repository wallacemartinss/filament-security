<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class AddDisposableDomainCommandTest extends TestCase
{
    #[Test]
    public function it_adds_a_domain_via_argument(): void
    {
        $this->artisan('filament-security:domain', [
            'action' => 'add',
            'domain' => 'command-test.com',
        ])
            ->assertSuccessful();

        DisposableEmailService::clearCache();
        $this->assertTrue(DisposableEmailService::isDisposable('user@command-test.com'));
    }

    #[Test]
    public function it_shows_warning_for_already_blocked_builtin_domain(): void
    {
        $this->artisan('filament-security:domain', [
            'action' => 'add',
            'domain' => 'mailinator.com',
        ])
            ->assertSuccessful();
    }

    #[Test]
    public function it_removes_a_domain_via_command(): void
    {
        DisposableEmailService::addDomain('to-remove-cmd.com');
        DisposableEmailService::clearCache();

        $this->artisan('filament-security:domain', [
            'action' => 'remove',
            'domain' => 'to-remove-cmd.com',
            '--force' => true,
        ])
            ->assertSuccessful();

        DisposableEmailService::clearCache();
        $this->assertFalse(DisposableEmailService::isDisposable('user@to-remove-cmd.com'));
    }

    #[Test]
    public function it_lists_custom_domains(): void
    {
        DisposableEmailService::addDomain('list-test-a.com');
        DisposableEmailService::addDomain('list-test-b.com');

        $this->artisan('filament-security:domain', [
            'action' => 'list',
        ])
            ->assertSuccessful();
    }

    #[Test]
    public function it_shows_empty_message_when_no_custom_domains(): void
    {
        $this->artisan('filament-security:domain', [
            'action' => 'list',
        ])
            ->assertSuccessful();
    }

    #[Test]
    public function it_shows_stats(): void
    {
        $this->artisan('filament-security:domain', [
            'action' => 'stats',
        ])
            ->assertSuccessful();
    }

    #[Test]
    public function it_fails_for_invalid_action(): void
    {
        $this->artisan('filament-security:domain', [
            'action' => 'invalid',
        ])
            ->assertFailed();
    }

    #[Test]
    public function it_registers_install_command(): void
    {
        $this->artisan('filament-security:install')
            ->assertSuccessful();
    }
}

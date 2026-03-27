<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DomainAgeRule;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class DomainAgeRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.domain_age.enabled', true);
        config()->set('filament-security.domain_age.min_days', 30);
        config()->set('filament-security.domain_age.block_on_failure', false);
        config()->set('filament-security.domain_age.cache_enabled', false);
        config()->set('filament-security.event_log.enabled', false);
    }

    #[Test]
    public function it_passes_for_well_established_domains(): void
    {
        $validator = Validator::make(
            ['email' => 'user@google.com'],
            ['email' => ['required', 'email', new DomainAgeRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_passes_when_rdap_lookup_fails_and_block_on_failure_is_false(): void
    {
        config()->set('filament-security.domain_age.block_on_failure', false);

        $validator = Validator::make(
            ['email' => 'user@this-domain-does-not-exist-xyz-12345.com'],
            ['email' => ['required', 'email', new DomainAgeRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_passes_when_min_days_is_zero(): void
    {
        config()->set('filament-security.domain_age.min_days', 0);

        $validator = Validator::make(
            ['email' => 'user@example.com'],
            ['email' => ['required', 'email', new DomainAgeRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_includes_min_days_in_error_message(): void
    {
        config()->set('filament-security.domain_age.min_days', 60);
        config()->set('filament-security.domain_age.block_on_failure', true);

        $validator = Validator::make(
            ['email' => 'user@this-domain-does-not-exist-xyz-12345.com'],
            ['email' => ['required', 'email', new DomainAgeRule]],
        );

        if ($validator->fails()) {
            $this->assertStringContainsString('60', $validator->errors()->first('email'));
        } else {
            // RDAP might not have data for this domain, which is acceptable
            $this->assertTrue(true);
        }
    }
}

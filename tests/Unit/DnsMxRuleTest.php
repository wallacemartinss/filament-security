<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DnsMxRule;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class DnsMxRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.dns_verification.cache_enabled', false);
        config()->set('filament-security.event_log.enabled', false);
    }

    #[Test]
    public function it_passes_for_valid_email_domains(): void
    {
        $validator = Validator::make(
            ['email' => 'user@gmail.com'],
            ['email' => ['required', 'email', new DnsMxRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_fails_for_nonexistent_domains(): void
    {
        $validator = Validator::make(
            ['email' => 'user@this-domain-does-not-exist-xyz-12345.com'],
            ['email' => ['required', 'email', new DnsMxRule]],
        );

        $this->assertTrue($validator->fails());
    }

    #[Test]
    public function it_returns_translated_error_message(): void
    {
        $validator = Validator::make(
            ['email' => 'user@this-domain-does-not-exist-xyz-12345.com'],
            ['email' => ['required', 'email', new DnsMxRule]],
        );

        $this->assertStringContainsString(
            'valid mail servers',
            $validator->errors()->first('email'),
        );
    }
}

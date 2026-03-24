<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DisposableEmailRule;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class DisposableEmailRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DisposableEmailService::clearCache();
    }

    #[Test]
    public function it_fails_validation_for_disposable_emails(): void
    {
        $validator = Validator::make(
            ['email' => 'user@mailinator.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    #[Test]
    public function it_passes_validation_for_legitimate_emails(): void
    {
        $validator = Validator::make(
            ['email' => 'user@gmail.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_fails_for_yopmail(): void
    {
        $validator = Validator::make(
            ['email' => 'test@yopmail.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertTrue($validator->fails());
    }

    #[Test]
    public function it_fails_for_guerrillamail(): void
    {
        $validator = Validator::make(
            ['email' => 'test@guerrillamail.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertTrue($validator->fails());
    }

    #[Test]
    public function it_passes_for_outlook(): void
    {
        $validator = Validator::make(
            ['email' => 'user@outlook.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_passes_for_yahoo(): void
    {
        $validator = Validator::make(
            ['email' => 'user@yahoo.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_fails_for_custom_blocked_domain(): void
    {
        DisposableEmailService::addDomain('my-blocked-domain.com');
        DisposableEmailService::clearCache();

        $validator = Validator::make(
            ['email' => 'test@my-blocked-domain.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertTrue($validator->fails());
    }

    #[Test]
    public function it_passes_for_whitelisted_domain(): void
    {
        config()->set('filament-security.disposable_email.whitelisted_domains', [
            'mailinator.com',
        ]);

        DisposableEmailService::clearCache();

        $validator = Validator::make(
            ['email' => 'user@mailinator.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_returns_translated_error_message(): void
    {
        $validator = Validator::make(
            ['email' => 'user@mailinator.com'],
            ['email' => ['required', 'email', new DisposableEmailRule]],
        );

        $this->assertTrue($validator->fails());

        $errors = $validator->errors()->get('email');
        $this->assertNotEmpty($errors);
        $this->assertIsString($errors[0]);
    }
}

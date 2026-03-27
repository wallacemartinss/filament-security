<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\SingleSession\SingleSessionService;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class SingleSessionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.single_session.enabled', true);
        config()->set('filament-security.event_log.enabled', false);
        config()->set('session.driver', 'database');
    }

    #[Test]
    public function it_generates_correct_cache_key(): void
    {
        $key = SingleSessionService::cacheKey(42);

        $this->assertSame('filament-security:active-session:42', $key);
    }

    #[Test]
    public function it_clears_tracking_from_cache(): void
    {
        Cache::put(SingleSessionService::cacheKey(1), 'session-abc', 3600);

        SingleSessionService::clearTracking(1);

        $this->assertNull(Cache::get(SingleSessionService::cacheKey(1)));
    }

    #[Test]
    public function it_sets_activate_session_flag_on_login(): void
    {
        $user = $this->createMockUser(1);

        SingleSessionService::handleLogin($user);

        $this->assertTrue(session()->has('filament-security:activate-session'));
    }

    #[Test]
    public function forced_logout_flag_defaults_to_false(): void
    {
        $this->assertFalse(SingleSessionService::$isForcedLogout);
    }

    private function createMockUser(int $id): \Illuminate\Contracts\Auth\Authenticatable
    {
        $user = $this->createMock(\Illuminate\Contracts\Auth\Authenticatable::class);
        $user->method('getAuthIdentifier')->willReturn($id);

        return $user;
    }
}

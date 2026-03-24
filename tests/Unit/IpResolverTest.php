<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\Cloudflare\IpResolver;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class IpResolverTest extends TestCase
{
    #[Test]
    public function it_resolves_cf_connecting_ip_header(): void
    {
        $request = Request::create('/');
        $request->headers->set('CF-Connecting-IP', '203.0.113.50');

        $this->assertEquals('203.0.113.50', IpResolver::resolve($request));
    }

    #[Test]
    public function it_resolves_x_real_ip_header(): void
    {
        $request = Request::create('/');
        $request->headers->set('X-Real-IP', '198.51.100.10');

        $this->assertEquals('198.51.100.10', IpResolver::resolve($request));
    }

    #[Test]
    public function it_resolves_x_forwarded_for_first_ip(): void
    {
        $request = Request::create('/');
        $request->headers->set('X-Forwarded-For', '192.0.2.1, 10.0.0.1, 172.16.0.1');

        $this->assertEquals('192.0.2.1', IpResolver::resolve($request));
    }

    #[Test]
    public function it_prioritizes_cf_connecting_ip_over_others(): void
    {
        $request = Request::create('/');
        $request->headers->set('CF-Connecting-IP', '203.0.113.50');
        $request->headers->set('X-Real-IP', '198.51.100.10');
        $request->headers->set('X-Forwarded-For', '192.0.2.1');

        $this->assertEquals('203.0.113.50', IpResolver::resolve($request));
    }

    #[Test]
    public function it_falls_back_to_remote_addr(): void
    {
        $request = Request::create('/');

        $ip = IpResolver::resolve($request);

        $this->assertNotEmpty($ip);
    }

    #[Test]
    public function it_sanitizes_invalid_ip(): void
    {
        $request = Request::create('/');
        $request->headers->set('CF-Connecting-IP', 'not-an-ip');

        $this->assertEquals('0.0.0.0', IpResolver::resolve($request));
    }

    #[Test]
    public function it_handles_ipv6(): void
    {
        $request = Request::create('/');
        $request->headers->set('CF-Connecting-IP', '2001:db8::1');

        $this->assertEquals('2001:db8::1', IpResolver::resolve($request));
    }
}

<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use WallaceMartinss\FilamentSecurity\Middleware\BlockMaliciousScans;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class BlockMaliciousScansTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filament-security.malicious_scan.enabled', true);
        config()->set('filament-security.event_log.enabled', true);
        config()->set('filament-security.ipinfo.token', '');
    }

    #[Test]
    public function it_blocks_env_file_access(): void
    {
        $this->assertPathBlocked('.env');
    }

    #[Test]
    public function it_blocks_git_access(): void
    {
        $this->assertPathBlocked('.git/config');
    }

    #[Test]
    public function it_blocks_wp_admin_access(): void
    {
        $this->assertPathBlocked('wp-admin');
    }

    #[Test]
    public function it_blocks_phpmyadmin_access(): void
    {
        $this->assertPathBlocked('phpmyadmin');
    }

    #[Test]
    public function it_blocks_shell_php_access(): void
    {
        $this->assertPathBlocked('shell.php');
    }

    #[Test]
    public function it_blocks_phpinfo_access(): void
    {
        $this->assertPathBlocked('phpinfo');
    }

    #[Test]
    public function it_blocks_directory_traversal(): void
    {
        $this->assertPathBlocked('../../etc/passwd');
    }

    #[Test]
    public function it_allows_legitimate_paths(): void
    {
        $this->assertPathAllowed('admin/dashboard');
        $this->assertPathAllowed('api/users');
        $this->assertPathAllowed('products/123');
    }

    #[Test]
    public function it_records_security_event_on_block(): void
    {
        $this->runMiddleware('wp-login.php');

        $this->assertDatabaseHas('security_events', [
            'type' => 'malicious_scan',
        ]);
    }

    #[Test]
    public function it_does_nothing_when_disabled(): void
    {
        config()->set('filament-security.malicious_scan.enabled', false);

        $this->assertPathAllowed('.env');
    }

    #[Test]
    public function it_is_case_insensitive(): void
    {
        $this->assertPathBlocked('WP-ADMIN');
        $this->assertPathBlocked('PhpMyAdmin');
    }

    private function assertPathBlocked(string $path): void
    {
        $blocked = $this->runMiddleware($path);
        $this->assertTrue($blocked, "Expected path '{$path}' to be blocked");
    }

    private function assertPathAllowed(string $path): void
    {
        $blocked = $this->runMiddleware($path);
        $this->assertFalse($blocked, "Expected path '{$path}' to be allowed");
    }

    private function runMiddleware(string $path): bool
    {
        $request = Request::create("/{$path}", 'GET');
        $middleware = new BlockMaliciousScans;

        try {
            $middleware->handle($request, function () {
                return response('OK');
            });

            return false;
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return true;
        }
    }
}

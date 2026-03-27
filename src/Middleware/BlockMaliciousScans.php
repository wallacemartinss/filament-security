<?php

namespace WallaceMartinss\FilamentSecurity\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class BlockMaliciousScans
{
    /**
     * Patterns that match as substrings (contain regex anchors).
     */
    private const SUBSTRING_PATTERNS = [
        '\.env',
        '\.git',
        '\.htaccess',
        '\.htpasswd',
        '\.DS_Store',
        'wp-config\.php',
        'application\.yml',
        'application\.properties',
        'package\.json',
        'package-lock\.json',
        'composer\.json',
        'composer\.lock',
        'yarn\.lock',
        'requirements\.txt',
        'database\.json',
        'db\.json',
        'settings\.json',
        'credentials\.json',
        'firebase.*\.json',
        'swagger\.json',
        'openapi\.json',
        'wp-admin',
        'wp-login',
        'wp-includes',
        'wp-content',
        'xmlrpc\.php',
        'info\.php',
        'shell\.php',
        'cmd\.php',
        'etc/passwd',
        'etc/shadow',
        'proc/self',
        '\.\./\.\.',
    ];

    /**
     * Patterns that require word boundaries to avoid false positives.
     */
    private const WORD_BOUNDARY_PATTERNS = [
        'c99',
        'r57',
        'webshell',
        'eval-stdin',
        'backdoor',
        'phpinfo',
        'php-info',
        'server-status',
        'server-info',
        '_debug',
        '_profiler',
        'actuator',
        'Gemfile',
    ];

    /**
     * Patterns that must be a complete URL path segment.
     */
    private const PATH_SEGMENT_PATTERNS = [
        'mysql',
        'adminer',
        'pgadmin',
        'phpmyadmin',
        'cPanel',
        'administrator',
    ];

    private ?string $compiledPattern = null;

    public function handle(Request $request, Closure $next): Response
    {
        if (! config('filament-security.malicious_scan.enabled', false)) {
            return $next($request);
        }

        $path = $request->path();

        if (preg_match($this->getPattern(), $path, $matches)) {
            SecurityEvent::record(SecurityEventType::MaliciousScan->value, [
                'metadata' => [
                    'method' => $request->method(),
                    'host' => $request->getHost(),
                    'matched_pattern' => $matches[0],
                ],
            ]);

            abort(404);
        }

        return $next($request);
    }

    private function getPattern(): string
    {
        if ($this->compiledPattern === null) {
            $substringPart = implode('|', self::SUBSTRING_PATTERNS);
            $wordBoundaryPart = implode('|', array_map(
                fn (string $p): string => '\b'.$p.'\b',
                self::WORD_BOUNDARY_PATTERNS,
            ));
            $pathSegmentPart = implode('|', array_map(
                fn (string $p): string => '(?:^|/)'.$p.'(?:/|$)',
                self::PATH_SEGMENT_PATTERNS,
            ));

            $this->compiledPattern = "#({$substringPart}|{$wordBoundaryPart}|{$pathSegmentPart})#i";
        }

        return $this->compiledPattern;
    }
}

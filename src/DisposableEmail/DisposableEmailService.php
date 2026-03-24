<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail;

use Illuminate\Support\Facades\Cache;

class DisposableEmailService
{
    protected static ?array $domains = null;

    protected static ?array $flipped = null;

    /**
     * Check if an email address uses a disposable domain.
     */
    public static function isDisposable(string $email): bool
    {
        $email = strtolower(trim($email));

        if (! str_contains($email, '@')) {
            return false;
        }

        [, $domain] = explode('@', $email, 2);

        return array_key_exists($domain, static::getFlippedDomains());
    }

    /**
     * Get the flipped domain list for O(1) lookup.
     */
    protected static function getFlippedDomains(): array
    {
        if (static::$flipped === null) {
            static::$flipped = array_flip(static::getAllDomains());
        }

        return static::$flipped;
    }

    /**
     * Get all blocked domains (built-in + custom config + custom file).
     */
    public static function getAllDomains(): array
    {
        if (static::$domains !== null) {
            return static::$domains;
        }

        $cacheEnabled = config('filament-security.disposable_email.cache_enabled', true);
        $cacheTtl = config('filament-security.disposable_email.cache_ttl', 1440);

        if ($cacheEnabled) {
            static::$domains = Cache::remember(
                'filament-security:disposable-domains',
                $cacheTtl * 60,
                fn () => static::loadDomains()
            );
        } else {
            static::$domains = static::loadDomains();
        }

        return static::$domains;
    }

    /**
     * Load and merge all domain sources.
     */
    protected static function loadDomains(): array
    {
        $builtIn = static::loadBuiltInDomains();
        $custom = static::loadCustomDomains();
        $configDomains = config('filament-security.disposable_email.custom_domains', []);
        $whitelisted = array_flip(config('filament-security.disposable_email.whitelisted_domains', []));

        $allDomains = array_unique(array_merge($builtIn, $custom, $configDomains));

        // Remove whitelisted domains
        $allDomains = array_filter($allDomains, fn ($domain) => ! isset($whitelisted[$domain]));

        return array_values($allDomains);
    }

    /**
     * Load the built-in JSON domain list.
     */
    protected static function loadBuiltInDomains(): array
    {
        $path = __DIR__.'/../../data/disposable-domains.json';

        if (! file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $domains = json_decode($content, true);

        return is_array($domains) ? $domains : [];
    }

    /**
     * Load custom domains from the storage file.
     */
    protected static function loadCustomDomains(): array
    {
        $path = storage_path('filament-security/custom-domains.txt');

        if (! file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $lines = explode("\n", $content);
        $domains = [];

        foreach ($lines as $line) {
            $line = strtolower(trim($line));

            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (preg_match('/^[a-z0-9.-]+\.[a-z]{2,}$/', $line)) {
                $domains[] = $line;
            }
        }

        return $domains;
    }

    /**
     * Add a domain to the custom blocklist.
     */
    public static function addDomain(string $domain): bool
    {
        $domain = strtolower(trim($domain));

        if (! preg_match('/^[a-z0-9.-]+\.[a-z]{2,}$/', $domain)) {
            return false;
        }

        $directory = storage_path('filament-security');
        $path = $directory.'/custom-domains.txt';

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Check if domain already exists
        $existing = static::loadCustomDomains();
        if (in_array($domain, $existing)) {
            return false;
        }

        file_put_contents($path, $domain."\n", FILE_APPEND | LOCK_EX);

        // Clear cache
        static::clearCache();

        return true;
    }

    /**
     * Remove a domain from the custom blocklist.
     */
    public static function removeDomain(string $domain): bool
    {
        $domain = strtolower(trim($domain));
        $path = storage_path('filament-security/custom-domains.txt');

        if (! file_exists($path)) {
            return false;
        }

        $domains = static::loadCustomDomains();
        $filtered = array_filter($domains, fn ($d) => $d !== $domain);

        if (count($domains) === count($filtered)) {
            return false;
        }

        file_put_contents($path, implode("\n", $filtered)."\n", LOCK_EX);

        static::clearCache();

        return true;
    }

    /**
     * Clear the cached domain list.
     */
    public static function clearCache(): void
    {
        Cache::forget('filament-security:disposable-domains');
        static::$domains = null;
        static::$flipped = null;
    }

    /**
     * Get domain count by source.
     */
    public static function getStats(): array
    {
        return [
            'built_in' => count(static::loadBuiltInDomains()),
            'custom_file' => count(static::loadCustomDomains()),
            'config' => count(config('filament-security.disposable_email.custom_domains', [])),
            'whitelisted' => count(config('filament-security.disposable_email.whitelisted_domains', [])),
            'total' => count(static::getAllDomains()),
        ];
    }
}

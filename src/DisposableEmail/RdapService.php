<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RdapService
{
    protected static ?array $bootstrapCache = null;

    /**
     * Check if a domain is too young based on RDAP registration data.
     *
     * Returns true if the domain is younger than the configured minimum age.
     */
    public static function isDomainTooYoung(string $email): bool
    {
        $email = strtolower(trim($email));

        if (! str_contains($email, '@')) {
            return false;
        }

        [, $domain] = explode('@', $email, 2);

        $minDays = (int) config('filament-security.domain_age.min_days', 30);

        if ($minDays <= 0) {
            return false;
        }

        $registrationDate = static::getRegistrationDate($domain);

        if ($registrationDate === null) {
            // If we can't determine the age, respect the config
            return config('filament-security.domain_age.block_on_failure', false);
        }

        $ageInDays = $registrationDate->diffInDays(Carbon::now());

        return $ageInDays < $minDays;
    }

    /**
     * Get the domain registration date via RDAP.
     */
    public static function getRegistrationDate(string $domain): ?Carbon
    {
        $cacheEnabled = config('filament-security.domain_age.cache_enabled', true);
        $cacheTtl = config('filament-security.domain_age.cache_ttl', 1440);

        $cacheKey = "filament-security:rdap-age:{$domain}";

        if ($cacheEnabled) {
            return Cache::remember(
                $cacheKey,
                $cacheTtl * 60,
                fn () => static::fetchRegistrationDate($domain)
            );
        }

        return static::fetchRegistrationDate($domain);
    }

    /**
     * Fetch the registration date from RDAP.
     */
    protected static function fetchRegistrationDate(string $domain): ?Carbon
    {
        try {
            $rdapUrl = static::getRdapServerUrl($domain);

            if ($rdapUrl === null) {
                return null;
            }

            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->get("{$rdapUrl}domain/{$domain}");

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();

            return static::extractRegistrationDate($data);
        } catch (\Throwable $e) {
            Log::warning('Filament Security: RDAP lookup failed', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Extract the registration date from RDAP response.
     */
    protected static function extractRegistrationDate(array $data): ?Carbon
    {
        $events = $data['events'] ?? [];

        foreach ($events as $event) {
            $action = $event['eventAction'] ?? '';

            if ($action === 'registration') {
                $date = $event['eventDate'] ?? null;

                if ($date !== null) {
                    return Carbon::parse($date);
                }
            }
        }

        return null;
    }

    /**
     * Get the RDAP server URL for a domain's TLD.
     */
    protected static function getRdapServerUrl(string $domain): ?string
    {
        $tld = static::extractTld($domain);

        if ($tld === null) {
            return null;
        }

        $bootstrap = static::getBootstrapData();

        if ($bootstrap === null) {
            return null;
        }

        foreach ($bootstrap['services'] ?? [] as $service) {
            $tlds = $service[0] ?? [];
            $urls = $service[1] ?? [];

            if (in_array($tld, $tlds, true) && ! empty($urls)) {
                $url = $urls[0];

                // Ensure trailing slash
                return str_ends_with($url, '/') ? $url : $url.'/';
            }
        }

        return null;
    }

    /**
     * Extract the TLD from a domain.
     */
    protected static function extractTld(string $domain): ?string
    {
        $parts = explode('.', $domain);

        if (count($parts) < 2) {
            return null;
        }

        return end($parts);
    }

    /**
     * Get the IANA RDAP bootstrap data.
     */
    protected static function getBootstrapData(): ?array
    {
        if (static::$bootstrapCache !== null) {
            return static::$bootstrapCache;
        }

        $cacheKey = 'filament-security:rdap-bootstrap';
        $cacheTtl = 86400; // 24 hours

        try {
            static::$bootstrapCache = Cache::remember($cacheKey, $cacheTtl, function () {
                $response = Http::timeout(10)
                    ->connectTimeout(5)
                    ->get('https://data.iana.org/rdap/dns.json');

                if (! $response->successful()) {
                    return null;
                }

                return $response->json();
            });

            return static::$bootstrapCache;
        } catch (\Throwable $e) {
            Log::warning('Filament Security: RDAP bootstrap fetch failed', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Clear cached RDAP data.
     */
    public static function clearCache(): void
    {
        Cache::forget('filament-security:rdap-bootstrap');
        static::$bootstrapCache = null;
    }
}

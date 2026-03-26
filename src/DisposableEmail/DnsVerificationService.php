<?php

namespace WallaceMartinss\FilamentSecurity\DisposableEmail;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DnsVerificationService
{
    /**
     * Check if a domain has suspicious DNS/MX configuration.
     *
     * Returns true if the domain is suspicious (no valid mail infrastructure).
     */
    public static function isSuspicious(string $email): bool
    {
        $email = strtolower(trim($email));

        if (! str_contains($email, '@')) {
            return false;
        }

        [, $domain] = explode('@', $email, 2);

        return static::isDomainSuspicious($domain);
    }

    /**
     * Check if a domain has suspicious DNS/MX records.
     */
    public static function isDomainSuspicious(string $domain): bool
    {
        $cacheEnabled = config('filament-security.dns_verification.cache_enabled', true);
        $cacheTtl = config('filament-security.dns_verification.cache_ttl', 60);

        if ($cacheEnabled) {
            return Cache::remember(
                "filament-security:dns-check:{$domain}",
                $cacheTtl * 60,
                fn () => static::performDnsCheck($domain)
            );
        }

        return static::performDnsCheck($domain);
    }

    /**
     * Perform the actual DNS verification.
     */
    protected static function performDnsCheck(string $domain): bool
    {
        try {
            // Check for MX records
            if (checkdnsrr($domain, 'MX')) {
                $mxRecords = dns_get_record($domain, DNS_MX);

                if (! empty($mxRecords)) {
                    // Check for suspicious MX targets
                    foreach ($mxRecords as $record) {
                        $target = $record['target'] ?? '';

                        if (static::isSuspiciousMxTarget($target)) {
                            return true;
                        }
                    }

                    // Has valid MX records
                    return false;
                }
            }

            // No MX records — check for A/AAAA as fallback (RFC 5321)
            if (checkdnsrr($domain, 'A') || checkdnsrr($domain, 'AAAA')) {
                return false;
            }

            // No MX, no A, no AAAA — domain cannot receive email
            return true;
        } catch (\Throwable $e) {
            Log::warning('Filament Security: DNS verification failed', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);

            // On failure, don't block the user
            return false;
        }
    }

    /**
     * Check if an MX target is suspicious.
     */
    protected static function isSuspiciousMxTarget(string $target): bool
    {
        $target = strtolower(trim($target, '.'));

        $suspiciousTargets = [
            'localhost',
            'localhost.localdomain',
            '.',
            '',
        ];

        if (in_array($target, $suspiciousTargets, true)) {
            return true;
        }

        // Check if MX points to loopback
        if (filter_var($target, FILTER_VALIDATE_IP)) {
            $ip = $target;
        } else {
            // Resolve the MX target to an IP
            $aRecords = @dns_get_record($target, DNS_A);
            $ip = ! empty($aRecords) ? ($aRecords[0]['ip'] ?? null) : null;
        }

        if ($ip !== null) {
            return static::isLoopbackOrPrivate($ip);
        }

        return false;
    }

    /**
     * Check if an IP is loopback or private (RFC 1918).
     */
    protected static function isLoopbackOrPrivate(string $ip): bool
    {
        return ! filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }
}

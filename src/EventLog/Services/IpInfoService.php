<?php

namespace WallaceMartinss\FilamentSecurity\EventLog\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpInfoService
{
    protected string $token;

    protected int $timeout;

    public function __construct()
    {
        $this->token = config('filament-security.ipinfo.token', '');
        $this->timeout = (int) config('filament-security.ipinfo.timeout', 5);
    }

    public function isConfigured(): bool
    {
        return ! empty($this->token);
    }

    /**
     * Get IP geolocation data with caching.
     *
     * @return array{country: ?string, city: ?string, org: ?string}|null
     */
    public function getIpInfo(string $ip): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        if ($this->isPrivateIp($ip)) {
            return null;
        }

        $cacheTtl = (int) config('filament-security.ipinfo.cache_ttl', 1440);

        return Cache::remember("filament-security:ipinfo:{$ip}", $cacheTtl * 60, function () use ($ip): ?array {
            return $this->fetchFromApi($ip);
        });
    }

    protected function fetchFromApi(string $ip): ?array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withToken($this->token)
                ->get("https://ipinfo.io/{$ip}");

            if (! $response->successful()) {
                Log::warning('Filament Security: IpInfo API request failed', [
                    'ip' => $ip,
                    'status' => $response->status(),
                ]);

                return null;
            }

            $data = $response->json();

            return [
                'country' => $data['country'] ?? null,
                'city' => $data['city'] ?? null,
                'org' => $data['org'] ?? null,
            ];
        } catch (\Throwable $e) {
            Log::warning('Filament Security: IpInfo API error', [
                'ip' => $ip,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    protected function isPrivateIp(string $ip): bool
    {
        return ! filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }
}

<?php

namespace WallaceMartinss\FilamentSecurity\Cloudflare;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareService
{
    protected string $baseUrl = 'https://api.cloudflare.com/client/v4';

    protected ?string $apiToken;

    protected ?string $zoneId;

    public function __construct()
    {
        $this->apiToken = config('filament-security.cloudflare.api_token');
        $this->zoneId = config('filament-security.cloudflare.zone_id');
    }

    /**
     * Block an IP address on Cloudflare WAF.
     */
    public function blockIp(string $ip, string $note = ''): ?array
    {
        if (! $this->isConfigured()) {
            Log::warning('FilamentSecurity: Cloudflare not configured. Cannot block IP.', ['ip' => $ip]);

            return null;
        }

        $mode = config('filament-security.cloudflare.mode', 'block');
        $notePrefix = config('filament-security.cloudflare.note_prefix', 'FilamentSecurity: Auto-blocked');

        $response = Http::withToken($this->apiToken)
            ->post("{$this->baseUrl}/zones/{$this->zoneId}/firewall/access_rules/rules", [
                'mode' => $mode,
                'configuration' => [
                    'target' => 'ip',
                    'value' => $ip,
                ],
                'notes' => trim("{$notePrefix} - {$note}"),
            ]);

        if ($response->successful() && $response->json('success')) {
            Log::info('FilamentSecurity: IP blocked on Cloudflare.', [
                'ip' => $ip,
                'mode' => $mode,
                'note' => $note,
            ]);

            return $response->json('result');
        }

        Log::error('FilamentSecurity: Failed to block IP on Cloudflare.', [
            'ip' => $ip,
            'status' => $response->status(),
            'errors' => $response->json('errors', []),
        ]);

        return null;
    }

    /**
     * Unblock an IP address on Cloudflare WAF.
     */
    public function unblockIp(string $ruleId): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $response = Http::withToken($this->apiToken)
            ->delete("{$this->baseUrl}/zones/{$this->zoneId}/firewall/access_rules/rules/{$ruleId}");

        if ($response->successful() && $response->json('success')) {
            Log::info('FilamentSecurity: IP unblocked on Cloudflare.', ['rule_id' => $ruleId]);

            return true;
        }

        Log::error('FilamentSecurity: Failed to unblock IP on Cloudflare.', [
            'rule_id' => $ruleId,
            'errors' => $response->json('errors', []),
        ]);

        return false;
    }

    /**
     * List blocked IPs on Cloudflare WAF.
     */
    public function listBlockedIps(int $page = 1, int $perPage = 20): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $response = Http::withToken($this->apiToken)
            ->get("{$this->baseUrl}/zones/{$this->zoneId}/firewall/access_rules/rules", [
                'mode' => 'block',
                'page' => $page,
                'per_page' => $perPage,
                'notes' => config('filament-security.cloudflare.note_prefix', 'FilamentSecurity'),
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiToken) && ! empty($this->zoneId);
    }
}

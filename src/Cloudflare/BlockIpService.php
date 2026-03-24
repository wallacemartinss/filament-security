<?php

namespace WallaceMartinss\FilamentSecurity\Cloudflare;

use Illuminate\Support\Facades\RateLimiter;
use WallaceMartinss\FilamentSecurity\Models\BlockedIp;

class BlockIpService
{
    protected CloudflareService $cloudflare;

    public function __construct(CloudflareService $cloudflare)
    {
        $this->cloudflare = $cloudflare;
    }

    /**
     * Record a failed attempt and block if threshold reached.
     */
    public function recordFailedAttempt(string $ip, string $reason = 'Failed login'): bool
    {
        if (! config('filament-security.cloudflare.enabled', false)) {
            return false;
        }

        if ($this->isAlreadyBlocked($ip)) {
            return false;
        }

        $maxAttempts = config('filament-security.cloudflare.max_attempts', 5);
        $decayMinutes = config('filament-security.cloudflare.decay_minutes', 30);
        $key = "filament-security:attempts:{$ip}";

        $executed = RateLimiter::attempt(
            $key,
            $maxAttempts,
            fn () => null,
            $decayMinutes * 60,
        );

        // If rate limit exceeded, block the IP
        if (! $executed) {
            return $this->blockIp($ip, $reason);
        }

        return false;
    }

    /**
     * Immediately block an IP (e.g., bot detected).
     */
    public function blockIp(string $ip, string $reason = 'Suspicious activity'): bool
    {
        if (! config('filament-security.cloudflare.enabled', false)) {
            return false;
        }

        if ($this->isAlreadyBlocked($ip)) {
            return false;
        }

        $result = $this->cloudflare->blockIp($ip, $reason);

        // Log to database regardless of Cloudflare result
        BlockedIp::create([
            'ip_address' => $ip,
            'reason' => $reason,
            'cloudflare_rule_id' => $result['id'] ?? null,
            'blocked_at' => now(),
        ]);

        // Clear the rate limiter for this IP
        RateLimiter::clear("filament-security:attempts:{$ip}");

        return true;
    }

    /**
     * Unblock an IP address.
     */
    public function unblockIp(string $ip): bool
    {
        $blockedIp = BlockedIp::where('ip_address', $ip)
            ->whereNull('unblocked_at')
            ->latest()
            ->first();

        if (! $blockedIp) {
            return false;
        }

        // Remove from Cloudflare if we have a rule ID
        if ($blockedIp->cloudflare_rule_id) {
            $this->cloudflare->unblockIp($blockedIp->cloudflare_rule_id);
        }

        $blockedIp->update(['unblocked_at' => now()]);

        return true;
    }

    /**
     * Check if an IP is already blocked.
     */
    public function isAlreadyBlocked(string $ip): bool
    {
        return BlockedIp::where('ip_address', $ip)
            ->whereNull('unblocked_at')
            ->exists();
    }

    /**
     * Get the remaining attempts before block.
     */
    public function remainingAttempts(string $ip): int
    {
        $maxAttempts = config('filament-security.cloudflare.max_attempts', 5);
        $key = "filament-security:attempts:{$ip}";

        return RateLimiter::remaining($key, $maxAttempts);
    }
}

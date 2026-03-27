<?php

namespace WallaceMartinss\FilamentSecurity\EventLog\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use WallaceMartinss\FilamentSecurity\EventLog\Services\IpInfoService;

class SecurityEvent extends Model
{
    use HasUuids;

    protected $fillable = [
        'type',
        'ip_address',
        'email',
        'domain',
        'path',
        'user_agent',
        'country',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (SecurityEvent $event) {
            if (empty($event->country) && $event->ip_address) {
                rescue(function () use ($event) {
                    $ipInfo = app(IpInfoService::class)->getIpInfo($event->ip_address);

                    if ($ipInfo) {
                        $event->country = $ipInfo['country'] ?? null;

                        $metadata = $event->metadata ?? [];
                        $metadata['city'] = $ipInfo['city'] ?? null;
                        $metadata['org'] = $ipInfo['org'] ?? null;
                        $event->metadata = $metadata;
                    }
                });
            }
        });
    }

    /**
     * Record a security event. Safe to call even if the table doesn't exist.
     */
    public static function record(string $type, array $data = []): ?self
    {
        if (! config('filament-security.event_log.enabled', false)) {
            return null;
        }

        return rescue(fn () => self::create([
            'type' => $type,
            'ip_address' => request()?->ip(),
            'path' => request()?->path(),
            'user_agent' => request()?->userAgent(),
            ...$data,
        ]));
    }
}

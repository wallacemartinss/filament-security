<?php

namespace WallaceMartinss\FilamentSecurity\Listeners;

use Illuminate\Auth\Events\Failed;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\IpResolver;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class HandleFailedLogin
{
    public function __construct(
        protected BlockIpService $blockIpService,
    ) {}

    public function handle(Failed $event): void
    {
        $ip = IpResolver::resolve();
        $email = $event->credentials['email'] ?? 'unknown';

        SecurityEvent::record(SecurityEventType::LoginLockout->value, [
            'ip_address' => $ip,
            'email' => $email,
        ]);

        if (! config('filament-security.cloudflare.enabled', false)) {
            return;
        }

        $this->blockIpService->recordFailedAttempt(
            $ip,
            "Failed login for: {$email}",
        );
    }
}

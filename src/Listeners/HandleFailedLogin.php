<?php

namespace WallaceMartinss\FilamentSecurity\Listeners;

use Illuminate\Auth\Events\Failed;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\IpResolver;

class HandleFailedLogin
{
    public function __construct(
        protected BlockIpService $blockIpService,
    ) {}

    public function handle(Failed $event): void
    {
        if (! config('filament-security.cloudflare.enabled', false)) {
            return;
        }

        $ip = IpResolver::resolve();

        $email = $event->credentials['email'] ?? 'unknown';

        $this->blockIpService->recordFailedAttempt(
            $ip,
            "Failed login for: {$email}",
        );
    }
}

<?php

namespace WallaceMartinss\FilamentSecurity\Listeners;

use Spatie\Honeypot\Events\SpamDetectedEvent;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\IpResolver;

class HandleSpamDetected
{
    public function __construct(
        protected BlockIpService $blockIpService,
    ) {}

    public function handle(SpamDetectedEvent $event): void
    {
        if (! config('filament-security.cloudflare.enabled', false)) {
            return;
        }

        $ip = IpResolver::resolve($event->request);

        $this->blockIpService->blockIp($ip, 'Bot detected (honeypot triggered)');
    }
}

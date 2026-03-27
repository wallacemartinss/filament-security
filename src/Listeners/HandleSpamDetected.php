<?php

namespace WallaceMartinss\FilamentSecurity\Listeners;

use Spatie\Honeypot\Events\SpamDetectedEvent;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\IpResolver;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class HandleSpamDetected
{
    public function __construct(
        protected BlockIpService $blockIpService,
    ) {}

    public function handle(SpamDetectedEvent $event): void
    {
        $ip = IpResolver::resolve($event->request);

        SecurityEvent::record(SecurityEventType::HoneypotTriggered->value, [
            'ip_address' => $ip,
        ]);

        if (! config('filament-security.cloudflare.enabled', false)) {
            return;
        }

        $this->blockIpService->blockIp($ip, 'Bot detected (honeypot triggered)');
    }
}

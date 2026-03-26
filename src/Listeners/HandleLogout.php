<?php

namespace WallaceMartinss\FilamentSecurity\Listeners;

use Illuminate\Auth\Events\Logout;
use WallaceMartinss\FilamentSecurity\SingleSession\SingleSessionService;

class HandleLogout
{
    public function handle(Logout $event): void
    {
        if (! config('filament-security.single_session.enabled', false)) {
            return;
        }

        // Don't clear tracking when the middleware forces a logout
        // (the new session should remain tracked as the active one)
        if (SingleSessionService::$isForcedLogout) {
            return;
        }

        if ($event->user) {
            SingleSessionService::clearTracking($event->user->getAuthIdentifier());
        }
    }
}

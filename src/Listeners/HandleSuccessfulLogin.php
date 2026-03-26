<?php

namespace WallaceMartinss\FilamentSecurity\Listeners;

use Illuminate\Auth\Events\Login;
use WallaceMartinss\FilamentSecurity\SingleSession\SingleSessionService;

class HandleSuccessfulLogin
{
    public function handle(Login $event): void
    {
        if (! config('filament-security.single_session.enabled', false)) {
            return;
        }

        SingleSessionService::handleLogin($event->user);
    }
}

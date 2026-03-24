<?php

namespace WallaceMartinss\FilamentSecurity\Auth;

use Filament\Auth\Pages\Register;
use WallaceMartinss\FilamentSecurity\Auth\Concerns\HasDisposableEmailProtection;
use WallaceMartinss\FilamentSecurity\Auth\Concerns\HasHoneypotProtection;

class FilamentSecurityRegister extends Register
{
    use HasDisposableEmailProtection;
    use HasHoneypotProtection;
}

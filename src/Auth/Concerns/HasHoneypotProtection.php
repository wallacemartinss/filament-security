<?php

namespace WallaceMartinss\FilamentSecurity\Auth\Concerns;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;

trait HasHoneypotProtection
{
    use UsesSpamProtection;

    public HoneypotData $honeyPostData;

    public function mountHasHoneypotProtection(): void
    {
        $this->honeyPostData = new HoneypotData;
    }

    protected function getHoneypotFormComponent(): Component
    {
        return View::make('filament-security::components.honeypot-fields');
    }

    public function form(Schema $schema): Schema
    {
        $components = [
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ];

        if (config('filament-security.honeypot.enabled', true)) {
            $components[] = $this->getHoneypotFormComponent();
        }

        return $schema->components($components);
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        if (config('filament-security.honeypot.enabled', true)) {
            $this->protectAgainstSpam();
        }

        return $data;
    }
}

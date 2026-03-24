<?php

namespace WallaceMartinss\FilamentSecurity\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'filament-security:install';

    protected $description = 'Install the Filament Security package';

    public function handle(): int
    {
        $this->info('Installing Filament Security...');

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'filament-security-config',
            '--force' => false,
        ]);

        $this->info('Config file published.');

        // Show env variables needed
        $this->newLine();
        $this->info('Add these variables to your .env file:');
        $this->newLine();
        $this->line('FILAMENT_SECURITY_DISPOSABLE_EMAIL=true');
        $this->line('FILAMENT_SECURITY_HONEYPOT=true');
        $this->line('FILAMENT_SECURITY_CLOUDFLARE=false');
        $this->line('CLOUDFLARE_API_TOKEN=');
        $this->line('CLOUDFLARE_ZONE_ID=');
        $this->newLine();

        // Show plugin registration
        $this->info('Register the plugin in your AdminPanelProvider:');
        $this->newLine();
        $this->line('use WallaceMartinss\FilamentSecurity\FilamentSecurityPlugin;');
        $this->newLine();
        $this->line('->plugin(');
        $this->line('    FilamentSecurityPlugin::make()');
        $this->line('        ->disposableEmailProtection()');
        $this->line('        ->honeypotProtection()');
        $this->line('        ->cloudflareBlocking()');
        $this->line(')');

        $this->newLine();
        $this->info('Filament Security installed successfully!');

        return self::SUCCESS;
    }
}

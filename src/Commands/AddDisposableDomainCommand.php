<?php

namespace WallaceMartinss\FilamentSecurity\Commands;

use Illuminate\Console\Command;
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class AddDisposableDomainCommand extends Command
{
    protected $signature = 'filament-security:domain
                            {action=add : The action to perform (add, remove, list, stats)}
                            {domain? : The domain to add or remove}
                            {--force : Skip confirmation prompts}';

    protected $description = 'Manage custom disposable email domains';

    public function handle(): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'add' => $this->addDomain(),
            'remove' => $this->removeDomain(),
            'list' => $this->listDomains(),
            'stats' => $this->showStats(),
            default => $this->invalidAction($action),
        };
    }

    protected function addDomain(): int
    {
        $domain = $this->argument('domain') ?? text(
            label: 'Enter the domain to block',
            placeholder: 'example-temp.com',
            required: true,
            validate: fn (string $value) => preg_match('/^[a-z0-9.-]+\.[a-z]{2,}$/', strtolower(trim($value)))
                ? null
                : 'Invalid domain format.',
        );

        $domain = strtolower(trim($domain));

        if (DisposableEmailService::isDisposable("test@{$domain}")) {
            warning("Domain '{$domain}' is already blocked.");

            return self::SUCCESS;
        }

        if (DisposableEmailService::addDomain($domain)) {
            info("Domain '{$domain}' added to the custom blocklist.");

            return self::SUCCESS;
        }

        warning("Failed to add domain '{$domain}'. It may already exist or have an invalid format.");

        return self::FAILURE;
    }

    protected function removeDomain(): int
    {
        $domain = $this->argument('domain') ?? text(
            label: 'Enter the domain to remove',
            placeholder: 'example-temp.com',
            required: true,
        );

        $domain = strtolower(trim($domain));

        if (! $this->option('force') && ! $this->option('no-interaction') && ! confirm("Remove '{$domain}' from the custom blocklist?")) {
            info('Cancelled.');

            return self::SUCCESS;
        }

        if (DisposableEmailService::removeDomain($domain)) {
            info("Domain '{$domain}' removed from the custom blocklist.");

            return self::SUCCESS;
        }

        warning("Domain '{$domain}' was not found in the custom blocklist.");

        return self::FAILURE;
    }

    protected function listDomains(): int
    {
        $path = storage_path('filament-security/custom-domains.txt');

        if (! file_exists($path)) {
            info('No custom domains added yet.');

            return self::SUCCESS;
        }

        $domains = array_filter(
            array_map('trim', explode("\n", file_get_contents($path))),
            fn ($line) => ! empty($line) && ! str_starts_with($line, '#'),
        );

        if (empty($domains)) {
            info('No custom domains added yet.');

            return self::SUCCESS;
        }

        table(
            headers: ['#', 'Domain'],
            rows: array_map(
                fn ($domain, $index) => [$index + 1, $domain],
                array_values($domains),
                array_keys(array_values($domains)),
            ),
        );

        return self::SUCCESS;
    }

    protected function showStats(): int
    {
        $stats = DisposableEmailService::getStats();

        table(
            headers: ['Source', 'Count'],
            rows: [
                ['Built-in domains', number_format($stats['built_in'])],
                ['Custom file domains', number_format($stats['custom_file'])],
                ['Config domains', number_format($stats['config'])],
                ['Whitelisted domains', number_format($stats['whitelisted'])],
                ['Total active domains', number_format($stats['total'])],
            ],
        );

        return self::SUCCESS;
    }

    protected function invalidAction(string $action): int
    {
        warning("Invalid action: '{$action}'. Use: add, remove, list, or stats.");

        return self::FAILURE;
    }
}

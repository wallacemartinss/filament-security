<?php

namespace WallaceMartinss\FilamentSecurity\Commands;

use Illuminate\Console\Command;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\CloudflareService;
use WallaceMartinss\FilamentSecurity\Models\BlockedIp;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class ManageBlockedIpsCommand extends Command
{
    protected $signature = 'filament-security:blocked-ips
                            {action=list : The action to perform (list, block, unblock, status)}
                            {ip? : The IP address to block or unblock}
                            {--reason= : Reason for blocking}
                            {--force : Skip confirmation prompts}';

    protected $description = 'Manage blocked IP addresses';

    public function handle(BlockIpService $blockIpService, CloudflareService $cloudflareService): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'list' => $this->listBlocked(),
            'block' => $this->blockIp($blockIpService),
            'unblock' => $this->unblockIp($blockIpService),
            'status' => $this->showStatus($cloudflareService),
            default => $this->invalidAction($action),
        };
    }

    protected function listBlocked(): int
    {
        $blocked = BlockedIp::active()->latest('blocked_at')->get();

        if ($blocked->isEmpty()) {
            info('No blocked IPs.');

            return self::SUCCESS;
        }

        table(
            headers: ['IP Address', 'Reason', 'Cloudflare Rule', 'Blocked At'],
            rows: $blocked->map(fn (BlockedIp $ip) => [
                $ip->ip_address,
                $ip->reason,
                $ip->cloudflare_rule_id ?? 'N/A',
                $ip->blocked_at->format('Y-m-d H:i:s'),
            ])->toArray(),
        );

        return self::SUCCESS;
    }

    protected function blockIp(BlockIpService $blockIpService): int
    {
        $ip = $this->argument('ip') ?? text(
            label: 'Enter the IP address to block',
            placeholder: '192.168.1.1',
            required: true,
            validate: fn (string $value) => filter_var(trim($value), FILTER_VALIDATE_IP)
                ? null
                : 'Invalid IP address.',
        );

        $reason = $this->option('reason') ?? 'Manual block via CLI';

        if ($blockIpService->blockIp($ip, $reason)) {
            info("IP '{$ip}' has been blocked.");

            return self::SUCCESS;
        }

        warning("Failed to block IP '{$ip}'. It may already be blocked or Cloudflare is not configured.");

        return self::FAILURE;
    }

    protected function unblockIp(BlockIpService $blockIpService): int
    {
        $ip = $this->argument('ip') ?? text(
            label: 'Enter the IP address to unblock',
            placeholder: '192.168.1.1',
            required: true,
        );

        if (! $this->option('force') && ! $this->option('no-interaction')) {
            if (! confirm("Unblock IP '{$ip}'?")) {
                info('Cancelled.');

                return self::SUCCESS;
            }
        }

        if ($blockIpService->unblockIp($ip)) {
            info("IP '{$ip}' has been unblocked.");

            return self::SUCCESS;
        }

        warning("IP '{$ip}' was not found in the blocked list.");

        return self::FAILURE;
    }

    protected function showStatus(CloudflareService $cloudflareService): int
    {
        $localCount = BlockedIp::active()->count();
        $totalCount = BlockedIp::count();
        $configured = $cloudflareService->isConfigured();

        table(
            headers: ['Setting', 'Value'],
            rows: [
                ['Cloudflare configured', $configured ? 'Yes' : 'No'],
                ['Cloudflare enabled', config('filament-security.cloudflare.enabled') ? 'Yes' : 'No'],
                ['Block mode', config('filament-security.cloudflare.mode', 'block')],
                ['Max attempts', (string) config('filament-security.cloudflare.max_attempts', 5)],
                ['Decay minutes', (string) config('filament-security.cloudflare.decay_minutes', 30)],
                ['Active blocks', (string) $localCount],
                ['Total blocks (all time)', (string) $totalCount],
            ],
        );

        return self::SUCCESS;
    }

    protected function invalidAction(string $action): int
    {
        warning("Invalid action: '{$action}'. Use: list, block, unblock, or status.");

        return self::FAILURE;
    }
}

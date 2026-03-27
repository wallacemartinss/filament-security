<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;
use WallaceMartinss\FilamentSecurity\EventLog\Services\IpInfoService;

class BackfillIpLocationAction
{
    public static function make(): Action
    {
        $pending = rescue(
            fn () => SecurityEvent::whereNull('country')
                ->whereNotNull('ip_address')
                ->distinct('ip_address')
                ->count('ip_address'),
            0
        );

        return Action::make('backfill_ip_location')
            ->label(__('filament-security::messages.event_log.actions.backfill_label', ['count' => $pending]))
            ->icon('heroicon-o-map-pin')
            ->color('info')
            ->visible($pending > 0)
            ->requiresConfirmation()
            ->modalHeading(__('filament-security::messages.event_log.actions.backfill_heading'))
            ->modalDescription(__('filament-security::messages.event_log.actions.backfill_description', ['count' => $pending]))
            ->modalSubmitActionLabel(__('filament-security::messages.event_log.actions.backfill_submit'))
            ->action(function () {
                $ipInfo = app(IpInfoService::class);

                if (! $ipInfo->isConfigured()) {
                    Notification::make()
                        ->danger()
                        ->title(__('filament-security::messages.event_log.actions.ipinfo_not_configured'))
                        ->body(__('filament-security::messages.event_log.actions.ipinfo_not_configured_body'))
                        ->send();

                    return;
                }

                $ips = SecurityEvent::whereNull('country')
                    ->whereNotNull('ip_address')
                    ->distinct()
                    ->pluck('ip_address');

                $enriched = 0;
                $failed = 0;

                foreach ($ips as $ip) {
                    $info = $ipInfo->getIpInfo($ip);

                    if ($info && ! empty($info['country'])) {
                        SecurityEvent::where('ip_address', $ip)
                            ->whereNull('country')
                            ->each(function (SecurityEvent $event) use ($info) {
                                $metadata = $event->metadata ?? [];
                                $metadata['city'] = $info['city'] ?? null;
                                $metadata['org'] = $info['org'] ?? null;

                                $event->update([
                                    'country' => $info['country'],
                                    'metadata' => $metadata,
                                ]);
                            });

                        $enriched++;
                    } else {
                        $failed++;
                    }
                }

                Notification::make()
                    ->success()
                    ->title(__('filament-security::messages.event_log.actions.backfill_complete'))
                    ->body(__('filament-security::messages.event_log.actions.backfill_result', [
                        'enriched' => $enriched,
                        'failed' => $failed,
                    ]))
                    ->persistent()
                    ->send();
            });
    }
}

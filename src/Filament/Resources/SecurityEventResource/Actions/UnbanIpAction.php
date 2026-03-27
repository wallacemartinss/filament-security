<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class UnbanIpAction
{
    public static function make(): Action
    {
        return Action::make('unban_ip')
            ->label(__('filament-security::messages.event_log.actions.unban_label'))
            ->icon('heroicon-o-shield-check')
            ->color('success')
            ->visible(fn ($record) => self::ipIsBanned($record))
            ->requiresConfirmation()
            ->modalHeading(__('filament-security::messages.event_log.actions.unban_heading'))
            ->modalDescription(fn ($record) => __('filament-security::messages.event_log.actions.unban_description', ['ip' => $record->ip_address]))
            ->action(function ($record) {
                if (config('filament-security.cloudflare.enabled', false)) {
                    rescue(fn () => app(BlockIpService::class)->unblockIp($record->ip_address));
                }

                SecurityEvent::record(SecurityEventType::IpUnblocked->value, [
                    'ip_address' => $record->ip_address,
                    'metadata' => [
                        'unbanned_via' => 'filament_panel',
                    ],
                ]);

                Notification::make()
                    ->success()
                    ->title(__('filament-security::messages.event_log.actions.unban_success', ['ip' => $record->ip_address]))
                    ->send();
            });
    }

    private static function ipIsBanned($record): bool
    {
        if ($record->type === SecurityEventType::IpBlocked->value) {
            return ! SecurityEvent::where('ip_address', $record->ip_address)
                ->where('type', SecurityEventType::IpUnblocked->value)
                ->where('created_at', '>', $record->created_at)
                ->exists();
        }

        $lastBan = SecurityEvent::where('ip_address', $record->ip_address)
            ->where('type', SecurityEventType::IpBlocked->value)
            ->latest()
            ->first();

        if (! $lastBan) {
            return false;
        }

        return ! SecurityEvent::where('ip_address', $record->ip_address)
            ->where('type', SecurityEventType::IpUnblocked->value)
            ->where('created_at', '>', $lastBan->created_at)
            ->exists();
    }
}

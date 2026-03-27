<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class SecurityStatsOverview extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $todayCount = rescue(fn () => SecurityEvent::whereDate('created_at', today())->count(), 0);
        $yesterdayCount = rescue(fn () => SecurityEvent::whereDate('created_at', today()->subDay())->count(), 0);
        $trend = $yesterdayCount > 0
            ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1)
            : 0;

        $blockedToday = rescue(
            fn () => SecurityEvent::where('type', SecurityEventType::IpBlocked->value)
                ->whereDate('created_at', today())
                ->count(),
            0
        );

        $weekCount = rescue(fn () => SecurityEvent::where('created_at', '>=', now()->subWeek())->count(), 0);

        $topThreat = rescue(
            fn () => SecurityEvent::query()
                ->select('type', DB::raw('count(*) as total'))
                ->where('created_at', '>=', now()->subWeek())
                ->whereNotIn('type', [
                    SecurityEventType::IpBlocked->value,
                    SecurityEventType::IpUnblocked->value,
                ])
                ->groupBy('type')
                ->orderByDesc('total')
                ->first(),
            null
        );

        $topThreatLabel = $topThreat
            ? (SecurityEventType::tryFrom($topThreat->type)?->getLabel() ?? '-')
            : '-';
        $topThreatCount = $topThreat ? $topThreat->total : 0;

        $uniqueIps = rescue(
            fn () => SecurityEvent::where('created_at', '>=', now()->subWeek())
                ->distinct('ip_address')
                ->count('ip_address'),
            0
        );

        return [
            Stat::make(__('filament-security::messages.event_log.stats.events_today'), number_format($todayCount))
                ->description($trend >= 0 ? "+{$trend}% vs yesterday" : "{$trend}% vs yesterday")
                ->descriptionIcon($trend >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($todayCount > 50 ? 'danger' : ($todayCount > 10 ? 'warning' : 'success'))
                ->chart($this->getLast7DaysData()),

            Stat::make(__('filament-security::messages.event_log.stats.ips_blocked_today'), number_format($blockedToday))
                ->description(__('filament-security::messages.event_log.stats.auto_blocked'))
                ->descriptionIcon('heroicon-o-shield-exclamation')
                ->color($blockedToday > 0 ? 'danger' : 'success'),

            Stat::make(__('filament-security::messages.event_log.stats.top_threat'), $topThreatLabel)
                ->description("{$topThreatCount} occurrences")
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Stat::make(__('filament-security::messages.event_log.stats.unique_ips'), number_format($uniqueIps))
                ->description("{$weekCount} total events")
                ->descriptionIcon('heroicon-o-globe-alt')
                ->color('info'),
        ];
    }

    /**
     * @return array<int>
     */
    protected function getLast7DaysData(): array
    {
        return rescue(function () {
            $data = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = today()->subDays($i);
                $data[] = SecurityEvent::whereDate('created_at', $date)->count();
            }

            return $data;
        }, [0, 0, 0, 0, 0, 0, 0]);
    }
}

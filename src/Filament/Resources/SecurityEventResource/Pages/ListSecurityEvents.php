<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Actions\BackfillIpLocationAction;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets\SecurityEventsByTypeChart;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets\SecurityStatsOverview;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets\SecurityThreatChart;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets\TopAttackersTable;

class ListSecurityEvents extends ListRecords
{
    protected static string $resource = SecurityEventResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SecurityStatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            SecurityThreatChart::class,
            SecurityEventsByTypeChart::class,
            TopAttackersTable::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 4;
    }

    public function getFooterWidgetsColumns(): int|array
    {
        return 3;
    }

    protected function getHeaderActions(): array
    {
        return [
            BackfillIpLocationAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'email' => Tab::make(__('filament-security::messages.event_log.tabs.email'))
                ->icon('heroicon-o-envelope')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('type', SecurityEventType::valuesByCategory('email')))
                ->badge($this->getCategoryTodayCount('email') ?: null)
                ->badgeColor('warning'),

            'bot_scan' => Tab::make(__('filament-security::messages.event_log.tabs.bot_scan'))
                ->icon('heroicon-o-bug-ant')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('type', SecurityEventType::valuesByCategory('bot_scan')))
                ->badge($this->getCategoryTodayCount('bot_scan') ?: null)
                ->badgeColor('danger'),

            'session' => Tab::make(__('filament-security::messages.event_log.tabs.session'))
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('type', SecurityEventType::valuesByCategory('session')))
                ->badge($this->getCategoryTodayCount('session') ?: null)
                ->badgeColor('info'),

            'auth' => Tab::make(__('filament-security::messages.event_log.tabs.auth'))
                ->icon('heroicon-o-lock-closed')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('type', SecurityEventType::valuesByCategory('auth')))
                ->badge($this->getCategoryTodayCount('auth') ?: null)
                ->badgeColor('warning'),

            'ip_management' => Tab::make(__('filament-security::messages.event_log.tabs.ip_management'))
                ->icon('heroicon-o-shield-exclamation')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('type', SecurityEventType::valuesByCategory('ip_management')))
                ->badge($this->getCategoryTodayCount('ip_management') ?: null)
                ->badgeColor('danger'),
        ];
    }

    private function getCategoryTodayCount(string $category): int
    {
        return rescue(
            fn () => SecurityEvent::whereIn('type', SecurityEventType::valuesByCategory($category))
                ->whereDate('created_at', today())
                ->count(),
            0
        );
    }
}

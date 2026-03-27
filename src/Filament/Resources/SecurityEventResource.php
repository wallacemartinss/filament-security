<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Pages\ListSecurityEvents;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Tables\SecurityEventsTable;

class SecurityEventResource extends Resource
{
    protected static ?string $model = SecurityEvent::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?int $navigationSort = 110;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-security::messages.event_log.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-security::messages.event_log.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-security::messages.event_log.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-security::messages.event_log.plural_model_label');
    }

    public static function getNavigationBadge(): ?string
    {
        $todayCount = rescue(fn () => static::getModel()::whereDate('created_at', today())->count(), 0);

        return $todayCount > 0 ? (string) $todayCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return __('filament-security::messages.event_log.badge_tooltip');
    }

    public static function table(Table $table): Table
    {
        return SecurityEventsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSecurityEvents::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}

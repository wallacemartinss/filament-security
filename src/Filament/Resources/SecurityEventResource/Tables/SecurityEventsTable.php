<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component as Livewire;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Actions\UnbanIpAction;

class SecurityEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label(__('filament-security::messages.event_log.table.type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state) => SecurityEventType::tryFrom($state)?->getLabel() ?? $state)
                    ->color(fn (string $state) => SecurityEventType::tryFrom($state)?->getColor() ?? 'gray')
                    ->icon(fn (string $state) => SecurityEventType::tryFrom($state)?->getIcon())
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('country')
                    ->label(__('filament-security::messages.event_log.table.location'))
                    ->placeholder('-')
                    ->formatStateUsing(fn (?string $state) => $state ? self::countryFlag($state).' '.$state : null)
                    ->tooltip(fn ($record) => self::locationTooltip($record)),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('-')
                    ->limit(30)
                    ->visible(fn (Livewire $livewire) => self::isTab($livewire, ['email'])),

                TextColumn::make('domain')
                    ->label(__('filament-security::messages.event_log.table.domain'))
                    ->placeholder('-')
                    ->badge()
                    ->color('warning')
                    ->visible(fn (Livewire $livewire) => self::isTab($livewire, ['email'])),

                TextColumn::make('path')
                    ->label('Path')
                    ->placeholder('-')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->path)
                    ->visible(fn (Livewire $livewire) => self::isTab($livewire, ['bot_scan'])),

                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->placeholder('-')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->user_agent)
                    ->visible(fn (Livewire $livewire) => self::isTab($livewire, ['bot_scan'])),

                TextColumn::make('metadata.trigger_type')
                    ->label(__('filament-security::messages.event_log.table.trigger'))
                    ->placeholder('-')
                    ->badge()
                    ->color('danger')
                    ->visible(fn (Livewire $livewire) => self::isTab($livewire, ['ip_management'])),

                TextColumn::make('metadata.trigger_count')
                    ->label(__('filament-security::messages.event_log.table.count'))
                    ->placeholder('-')
                    ->badge()
                    ->color('gray')
                    ->visible(fn (Livewire $livewire) => self::isTab($livewire, ['ip_management'])),

                TextColumn::make('created_at')
                    ->label(__('filament-security::messages.event_log.table.date'))
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('filament-security::messages.event_log.table.type'))
                    ->options(SecurityEventType::class)
                    ->multiple(),
            ])
            ->recordActions([
                UnbanIpAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s')
            ->striped()
            ->paginated([25, 50, 100]);
    }

    private static function isTab(Livewire $livewire, array $tabs): bool
    {
        $activeTab = $livewire->activeTab ?? null;

        if ($activeTab === null) {
            return false;
        }

        return in_array($activeTab, $tabs);
    }

    private static function countryFlag(?string $countryCode): string
    {
        if (! $countryCode || strlen($countryCode) !== 2) {
            return '';
        }

        $code = strtoupper($countryCode);

        return mb_chr(0x1F1E6 + ord($code[0]) - ord('A'))
            .mb_chr(0x1F1E6 + ord($code[1]) - ord('A'));
    }

    private static function locationTooltip($record): ?string
    {
        $metadata = $record->metadata ?? [];

        $parts = array_filter([
            $metadata['city'] ?? null,
            $record->country,
            $metadata['org'] ?? null,
        ]);

        return $parts ? implode(' · ', $parts) : null;
    }
}

<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class TopAttackersTable extends Widget
{
    protected static bool $isDiscovered = false;

    protected string $view = 'filament-security::widgets.top-attackers-table';

    protected int|string|array $columnSpan = 'full';

    public function getAttackers(): Collection
    {
        return rescue(
            fn () => SecurityEvent::query()
                ->select(
                    'ip_address',
                    DB::raw('count(*) as events_count'),
                    DB::raw('count(distinct type) as types_count'),
                    DB::raw('max(created_at) as last_seen'),
                    DB::raw('max(country) as country'),
                    DB::raw("MAX(CASE WHEN type = '".SecurityEventType::IpBlocked->value."' THEN 1 ELSE 0 END) as is_banned"),
                )
                ->where('created_at', '>=', now()->subWeek())
                ->groupBy('ip_address')
                ->orderByDesc('events_count')
                ->limit(10)
                ->get(),
            collect()
        );
    }

    public static function countryFlag(?string $countryCode): string
    {
        if (! $countryCode || strlen($countryCode) !== 2) {
            return '';
        }

        $code = strtoupper($countryCode);

        return mb_chr(0x1F1E6 + ord($code[0]) - ord('A'))
            .mb_chr(0x1F1E6 + ord($code[1]) - ord('A'));
    }
}

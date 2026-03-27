<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets;

use Filament\Widgets\ChartWidget;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class SecurityEventsByTypeChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $maxHeight = '250px';

    protected int|string|array $columnSpan = 1;

    public function getHeading(): ?string
    {
        return __('filament-security::messages.event_log.charts.events_by_type');
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $colors = [];

        $colorMap = [
            'disposable_email' => '#f59e0b',
            'dns_mx_suspicious' => '#d97706',
            'domain_too_young' => '#b45309',
            'session_terminated' => '#3b82f6',
            'honeypot_triggered' => '#ef4444',
            'malicious_scan' => '#b91c1c',
            'login_lockout' => '#dc2626',
            'ip_blocked' => '#991b1b',
            'ip_unblocked' => '#22c55e',
        ];

        foreach (SecurityEventType::cases() as $type) {
            $count = rescue(
                fn () => SecurityEvent::where('type', $type->value)
                    ->where('created_at', '>=', now()->subWeek())
                    ->count(),
                0
            );

            if ($count > 0) {
                $data[] = $count;
                $labels[] = $type->getLabel();
                $colors[] = $colorMap[$type->value] ?? '#6b7280';
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
            ],
            'cutout' => '60%',
        ];
    }
}

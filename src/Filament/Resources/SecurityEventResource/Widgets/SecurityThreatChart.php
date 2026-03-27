<?php

namespace WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets;

use Filament\Widgets\ChartWidget;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class SecurityThreatChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $maxHeight = '250px';

    protected int|string|array $columnSpan = 2;

    public function getHeading(): ?string
    {
        return __('filament-security::messages.event_log.charts.threat_activity');
    }

    protected function getData(): array
    {
        $categories = [
            'email' => ['label' => 'Email', 'color' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.1)'],
            'bot_scan' => ['label' => 'Bots & Scans', 'color' => '#ef4444', 'bg' => 'rgba(239, 68, 68, 0.1)'],
            'auth' => ['label' => 'Auth', 'color' => '#8b5cf6', 'bg' => 'rgba(139, 92, 246, 0.1)'],
            'session' => ['label' => 'Session', 'color' => '#3b82f6', 'bg' => 'rgba(59, 130, 246, 0.1)'],
        ];

        $datasets = [];
        $labels = [];

        for ($i = 13; $i >= 0; $i--) {
            $labels[] = today()->subDays($i)->format('d/m');
        }

        foreach ($categories as $category => $config) {
            $types = SecurityEventType::valuesByCategory($category);
            $data = [];

            for ($i = 13; $i >= 0; $i--) {
                $date = today()->subDays($i);
                $data[] = rescue(
                    fn () => SecurityEvent::whereIn('type', $types)
                        ->whereDate('created_at', $date)
                        ->count(),
                    0
                );
            }

            $datasets[] = [
                'label' => $config['label'],
                'data' => $data,
                'borderColor' => $config['color'],
                'backgroundColor' => $config['bg'],
                'fill' => true,
                'tension' => 0.3,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class LrtjChart extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Grafik Gangguan LRV per system';
    protected static ?int $sort = 0;
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => '',
                    'data' => [7, 3, 2, 1],
                ],
            ],
            'labels' => ['Communication System', 'Carbody System', 'Auxiliary Electrical System', 'Pneumatic and Brake System'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getstyle(): string
    {
        return 'width: 100%;';
    }
}

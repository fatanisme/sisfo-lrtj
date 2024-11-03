<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('ISSUE (OPEN)', '1')->icon('heroicon-s-folder-open'),
            Stat::make('ISSUE (ON PROCESS)', '1')->icon('heroicon-s-cog'),
            Stat::make('ISSUE (CLOSED)', '5')->icon('heroicon-s-check-circle'),
        ];
    }
}

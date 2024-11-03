<?php

namespace App\Filament\Resources\MonitoringPerawatanResource\Pages;

use App\Filament\Resources\MonitoringPerawatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonitoringPerawatans extends ListRecords
{
    protected static string $resource = MonitoringPerawatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

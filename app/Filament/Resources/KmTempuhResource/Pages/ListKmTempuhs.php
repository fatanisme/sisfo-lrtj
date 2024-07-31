<?php

namespace App\Filament\Resources\KmTempuhResource\Pages;

use App\Filament\Resources\KmTempuhResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKmTempuhs extends ListRecords
{
    protected static string $resource = KmTempuhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

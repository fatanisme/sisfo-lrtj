<?php

namespace App\Filament\Resources\LRVResource\Pages;

use App\Filament\Resources\LRVResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLRVS extends ListRecords
{
    protected static string $resource = LRVResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

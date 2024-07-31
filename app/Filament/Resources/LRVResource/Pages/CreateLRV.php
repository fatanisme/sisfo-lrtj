<?php

namespace App\Filament\Resources\LRVResource\Pages;

use App\Filament\Resources\LRVResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLRV extends CreateRecord
{
    protected static string $resource = LRVResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }    
}

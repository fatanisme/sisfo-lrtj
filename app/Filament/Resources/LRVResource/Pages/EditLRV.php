<?php

namespace App\Filament\Resources\LRVResource\Pages;

use App\Filament\Resources\LRVResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLRV extends EditRecord
{
    protected static string $resource = LRVResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

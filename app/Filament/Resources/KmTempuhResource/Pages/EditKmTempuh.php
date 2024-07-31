<?php

namespace App\Filament\Resources\KmTempuhResource\Pages;

use App\Filament\Resources\KmTempuhResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKmTempuh extends EditRecord
{
    protected static string $resource = KmTempuhResource::class;

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

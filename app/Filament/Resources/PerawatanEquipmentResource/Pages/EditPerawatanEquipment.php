<?php

namespace App\Filament\Resources\PerawatanEquipmentResource\Pages;

use App\Filament\Resources\PerawatanEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerawatanEquipment extends EditRecord
{
    protected static string $resource = PerawatanEquipmentResource::class;

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

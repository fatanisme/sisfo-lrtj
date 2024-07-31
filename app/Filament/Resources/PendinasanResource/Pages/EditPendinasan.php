<?php

namespace App\Filament\Resources\PendinasanResource\Pages;

use App\Filament\Resources\PendinasanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendinasan extends EditRecord
{
    protected static string $resource = PendinasanResource::class;

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

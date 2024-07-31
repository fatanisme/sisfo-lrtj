<?php

namespace App\Filament\Resources\StamformasiResource\Pages;

use App\Filament\Resources\StamformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStamformasi extends EditRecord
{
    protected static string $resource = StamformasiResource::class;

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

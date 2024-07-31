<?php

namespace App\Filament\Resources\StamformasiResource\Pages;

use App\Filament\Resources\StamformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStamformasi extends CreateRecord
{
    protected static string $resource = StamformasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

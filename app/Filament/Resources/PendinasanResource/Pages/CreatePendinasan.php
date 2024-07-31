<?php

namespace App\Filament\Resources\PendinasanResource\Pages;

use App\Filament\Resources\PendinasanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;
use App\Models\Pendinasan;
use App\Models\Stamformasi;

class CreatePendinasan extends CreateRecord
{
    protected static string $resource = PendinasanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = Auth()->id();
        $tanggalMulai = Carbon::parse($data['tgl_pendinasan']);
        $statusPendinasan = $data['status_pendinasan'];
        $lrv = $data['lrv_id'];
        $location = $data['location'];

        $tanggalSekarang = $tanggalMulai;

        $pendinasan = [];

        $pendinasan[] = [
            'tgl_stamformasi' => $tanggalSekarang->toDateString(),
            'status_pendinasan' => $statusPendinasan,
            'lrv_id' => $lrv,
            'location' => $location,
            'user_id' => $userId
        ];

        Stamformasi::insert($pendinasan);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

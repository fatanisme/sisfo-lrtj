<?php

namespace App\Filament\Resources\PerawatanEquipmentResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Perawatanequipment;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PerawatanEquipmentResource;

class CreatePerawatanEquipment extends CreateRecord
{
    protected static string $resource = PerawatanEquipmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tanggalMulai = Carbon::parse($data['tgl_perawatan']);
        $statusPerawatan = $data['jenis_perawatan'];
        $equipment = $data['equipment_id'];

        $tanggalSekarang = $tanggalMulai;
        $tanggalAkhir = Carbon::create($tanggalMulai->year, 12, 31);

        $perawatans = [];

        $intervals = [
            "Perawatan harian" => 1,
            "Perawatan Mingguan" => 7,
            "Perawatan Bulanan" => 30,
            "Perawatan 3 bulanan" => 90,
            "Perawatan 6 bulanan" => 180,
        ];

        if (array_key_exists($statusPerawatan, $intervals)) {
            $interval = $intervals[$statusPerawatan];
            while ($tanggalSekarang <= $tanggalAkhir) {
                $nextDate = clone $tanggalSekarang;

                if ($statusPerawatan == "Perawatan Bulanan") {
                    $nextDate->addMonths(1);
                } elseif ($statusPerawatan == "Perawatan 3 bulanan") {
                    $nextDate->addMonths(3);
                } elseif ($statusPerawatan == "Perawatan 6 bulanan") {
                    $nextDate->addMonths(6);
                } else {
                    $nextDate->addDays($interval);
                }


                $perawatans[] = [
                    'tgl_perawatan' => $tanggalSekarang->toDateString(),
                    'jenis_perawatan' => $statusPerawatan,
                    'equipment_id' => $equipment,
                ];

                $tanggalSekarang = $nextDate;
            }


            if (!empty($perawatans)) {
                Perawatanequipment::insert($perawatans);
            }
        }

        // Ensure the date is in 'Y-m-d' format before returning the data
        $data['tgl_perawatan'] = $tanggalMulai->format('Y-m-d');

        return $data;
    }

    protected function getRedirectUrl(): string
    {

        $duplicateIds = DB::table('perawatan_equipment')
            ->select(DB::raw('MIN(id) as id'))
            ->groupBy('tgl_perawatan', 'jenis_perawatan', 'equipment_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('id');

        // Delete duplicate records based on the retrieved IDs
        Perawatanequipment::whereIn('id', $duplicateIds)->delete();
        return $this->getResource()::getUrl('index');
    }
}

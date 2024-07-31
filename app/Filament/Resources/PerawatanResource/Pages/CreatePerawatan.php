<?php

namespace App\Filament\Resources\PerawatanResource\Pages;

use Filament\Actions;
use App\Models\Perawatan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PerawatanResource;

class CreatePerawatan extends CreateRecord
{
    protected static string $resource = PerawatanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tanggalMulai = Carbon::parse($data['tgl_perawatan']);
        $statusPerawatan = $data['jenis_perawatan'];
        $lrv = $data['lrv_id'];

        $tanggalSekarang = $tanggalMulai;
        $tanggalAkhir = Carbon::create($tanggalMulai->year, 12, 31);

        $perawatans = [];

        $intervals = [
            "Periodik 3 harian" => 3,
            "Periodik 7 harian" => 7,
            "Periodik 4 bulanan" => 4 * 30 // Assuming 4 months as roughly 120 days
        ];

        if (array_key_exists($statusPerawatan, $intervals)) {
            $interval = $intervals[$statusPerawatan];
            while ($tanggalSekarang <= $tanggalAkhir) {
                $nextDate = clone $tanggalSekarang;

                if ($statusPerawatan == "Periodik 4 bulanan") {
                    $nextDate->addMonths(4);
                } else {
                    $nextDate->addDays($interval);
                }


                $perawatans[] = [
                    'tgl_perawatan' => $tanggalSekarang->toDateString(),
                    'jenis_perawatan' => $statusPerawatan,
                    'lrv_id' => $lrv,
                ];

                $tanggalSekarang = $nextDate;
            }


            if (!empty($perawatans)) {
                Perawatan::insert($perawatans);
            }
        }

        // Ensure the date is in 'Y-m-d' format before returning the data
        $data['tgl_perawatan'] = $tanggalMulai->format('Y-m-d');

        return $data;
    }

    protected function getRedirectUrl(): string
    {

        // Retrieve duplicate records' IDs
        $duplicateIds = DB::table('perawatans')
            ->select(DB::raw('MIN(id) as id'))
            ->groupBy('tgl_perawatan', 'jenis_perawatan', 'lrv_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('id');

        // Delete duplicate records based on the retrieved IDs
        Perawatan::whereIn('id', $duplicateIds)->delete();

        return $this->getResource()::getUrl('index');
    }
}

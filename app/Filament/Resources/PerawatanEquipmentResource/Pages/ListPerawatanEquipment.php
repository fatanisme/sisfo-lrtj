<?php

namespace App\Filament\Resources\PerawatanEquipmentResource\Pages;

use Filament\Actions;
use App\Models\Perawatanequipment;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PerawatanEquipmentResource;
use Illuminate\Support\Facades\DB;

class ListPerawatanEquipment extends ListRecords
{
    protected static string $resource = PerawatanEquipmentResource::class;

    public ?string $tableSortColumn = 'tgl_perawatan'; // Set the default sorting column

    public ?string $tableSortDirection = 'desc'; // Set the default sorting direction

    protected function getHeaderActions(): array
    {

        $years = DB::table('perawatan_equipment')
            ->selectRaw('YEAR(tgl_perawatan) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();

        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        return [
            Actions\Action::make('Export')
                ->form([
                    Select::make('bulan_perawatan')
                        ->label('Bulan Perawatanequipment')
                        ->options($months)
                        ->required(),
                    Select::make('tahun_perawatan')
                        ->label('Tahun Perawatanequipment')
                        ->options($years)
                        ->required(),
                ])
                ->action(function (array $data) {
                    return redirect()->route('export.perawatanequipment', [
                        'bulan_perawatan' => $data['bulan_perawatan'],
                        'tahun_perawatan' => $data['tahun_perawatan'],
                    ]);
                })
                ->slideOver()
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}

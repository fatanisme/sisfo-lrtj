<?php

namespace App\Filament\Resources\StamformasiResource\Pages;

use Filament\Actions;
use App\Models\Perawatan;
use App\Models\Stamformasi;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StamformasiResource;

class ListStamformasis extends ListRecords
{
    protected static string $resource = StamformasiResource::class;

    protected function getHeaderActions(): array
    {
        $years = Stamformasi::selectRaw('YEAR(tgl_stamformasi) as year')
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
                    Select::make('bulan_stamformasi')
                        ->label('Bulan Status LRV')
                        ->options($months)
                        ->required(),
                    Select::make('tahun_stamformasi')
                        ->label('Tahun Status LRV')
                        ->options($years)
                        ->required(),
                ])
                ->action(function (array $data) {
                    return redirect()->route('export.statuslrv', [
                        'bulan_stamformasi' => $data['bulan_stamformasi'],
                        'tahun_stamformasi' => $data['tahun_stamformasi'],
                    ]);
                })
                ->slideOver()
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PendinasanResource\Pages;

use Filament\Actions;
use App\Models\Pendinasan;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PendinasanResource;

class ListPendinasans extends ListRecords
{
    protected static string $resource = PendinasanResource::class;

    protected function getHeaderActions(): array
    {
        $years = Pendinasan::selectRaw('YEAR(tgl_pendinasan) as year')
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
                    Select::make('bulan_pendinasan')
                        ->label('Bulan Pendinasan')
                        ->options($months)
                        ->required(),
                    Select::make('tahun_pendinasan')
                        ->label('Tahun Pendinasan')
                        ->options($years)
                        ->required(),
                ])
                ->action(function (array $data) {
                    return redirect()->route('export.pendinasan', [
                        'bulan_pendinasan' => $data['bulan_pendinasan'],
                        'tahun_pendinasan' => $data['tahun_pendinasan'],
                    ]);
                })
                ->slideOver()
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}

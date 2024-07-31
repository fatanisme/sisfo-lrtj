<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PerawatanEquipment;
use Illuminate\Support\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;

class EquipmentToday extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 5;
    protected static ?string $label = 'Perawatan Equipment';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PerawatanEquipment::query()
                    ->where('tgl_perawatan', Carbon::now()->toDateString())
                    ->orderBy('tgl_perawatan', 'asc')
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('tgl_perawatan', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('equipment.equipment')
                    ->label('Equipment'),
                Tables\Columns\TextColumn::make('tgl_perawatan')
                    ->label('Tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('jenis_perawatan')
                    ->label('Jenis Perawatan'),
            ]);
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\MonitoringPerawatan;
use Illuminate\Support\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;

class MonitoringPerawatanToday extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 5;
    protected static ?string $label = 'Perawatan Equipment';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MonitoringPerawatan::query()
                    ->where('tgl_perawatan', Carbon::today()->toDateString())
                    ->orderBy('tgl_perawatan', 'asc')
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('tgl_perawatan', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tgl_perawatan')
                    ->label('Tanggal Perawatan'),
                Tables\Columns\TextColumn::make('jenis_perawatan')
                    ->label('Jenis Perawatan'),
                Tables\Columns\TextColumn::make('durasi')
                    ->label('Durasi'),
                Tables\Columns\TextColumn::make('persentase_penyelesaian')
                    ->label('Persentase Penyelesaian'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan'),
            ]);
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Gangguan;
use Illuminate\Support\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;

class GangguanToday extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 5;
    protected static ?string $label = 'Monitoring Gangguan';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Gangguan::query()
                    ->where('tgl_gangguan', Carbon::today()->toDateString())
                    ->orderBy('tgl_gangguan', 'asc')
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('tgl_gangguan', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tgl_gangguan')->date('d-m-Y'),
                Tables\Columns\TextColumn::make('lrv.lrv'),
                Tables\Columns\TextColumn::make('kabin'),
                Tables\Columns\TextColumn::make('informasi_gangguan'),
                Tables\Columns\TextColumn::make('andil_keterlambatan'),
                Tables\Columns\TextColumn::make('sistem_utama'),
                Tables\Columns\TextColumn::make('perangkat_spesifik'),
                Tables\Columns\TextColumn::make('deskripsi_fault'),
                Tables\Columns\TextColumn::make('status_maximo'),
                Tables\Columns\TextColumn::make('service_request'),
                Tables\Columns\TextColumn::make('status_action'),
                Tables\Columns\TextColumn::make('tindak_lanjut'),
                Tables\Columns\TextColumn::make('action_date'),
                Tables\Columns\TextColumn::make('close_date'),
                Tables\Columns\TextColumn::make('penggunaan_sparepart'),
                Tables\Columns\TextColumn::make('keterangan'),
            ]);
    }
}

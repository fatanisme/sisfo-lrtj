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
                Tables\Columns\TextColumn::make('tgl_gangguan')->translateLabel()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lrv.lrv')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kabin')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('informasi_gangguan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('andil_keterlambatan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('sistem_utama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('perangkat_spesifik')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('deskripsi_fault')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status_maximo')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('service_request')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status_action')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('tindak_lanjut')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('action_date')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('close_date')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('penggunaan_sparepart')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('keterangan')->sortable()->searchable(),
            ]);
    }
}

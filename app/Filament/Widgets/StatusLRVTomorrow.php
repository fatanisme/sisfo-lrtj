<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Stamformasi;
use Illuminate\Support\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;

class StatusLRVTomorrow extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;
    protected static ?string $label = 'Status LRV';

    public function table(Table $table): Table
    {

        return $table
            ->query(
                Stamformasi::query()
                    ->where('tgl_stamformasi', Carbon::tomorrow()->toDateString())
                    ->orderBy('tgl_stamformasi', 'asc')
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('tgl_stamformasi', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('lrv.lrv')
                    ->label('LRV'),
                Tables\Columns\TextColumn::make('lrv.nomor_ka')
                    ->label('Nomor KA'),
                Tables\Columns\TextColumn::make('tgl_stamformasi')
                    ->label('Tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('status_pendinasan')->badge()->color(fn(string $state): string => match ($state) {
                    'Tidak Siap Operasi' => 'danger',
                    'Siap Operasi' => 'success',
                    'Cadangan' => 'success',
                    default => 'warning',
                }),
                Tables\Columns\TextColumn::make('last_modified')
                    ->label('Last Modified'),

            ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitoringPerawatanResource\Pages;
use App\Filament\Resources\MonitoringPerawatanResource\RelationManagers;
use App\Models\MonitoringPerawatan;
use App\Models\Lrv;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonitoringPerawatanResource extends Resource
{
    protected static ?string $model = MonitoringPerawatan::class;

    protected static ?string $title = 'Monitoring Perawatan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Monitoring Perawatan';
    protected static ?int $navigationSort = 10;
    protected static ?string $slug = 'monitoringperawatan';
    protected static ?string $navigationGroup = 'Master Data';
    public static function form(Form $form): Form
    {
        $lrvOptions = LRV::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->lrv . ' | ' . $item->nomor_ka];
        });
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tgl_perawatan')
                    ->label('Tanggal Perawatan')
                    ->default(now())
                    ->required(),

                Forms\Components\Select::make('lrv_id')
                    ->relationship('lrv', 'lrv')
                    ->options($lrvOptions)
                    ->searchable()
                    ->label('LRV')
                    ->required(),
                Forms\Components\TextInput::make('jenis_perawatan')
                    ->label('Jenis Perawatan')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('durasi')
                    ->label('Durasi')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('persentase_penyelesaian')
                    ->label('Persentase Penyelesaian')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->label('Status')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_perawatan')
                    ->label('Tanggal Perawatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lrv.lrv')
                    ->label('LRV')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_perawatan')
                    ->label('Jenis Perawatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('durasi')
                    ->label('Durasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('persentase_penyelesaian')
                    ->label('Persentase Penyelesaian')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonitoringPerawatans::route('/'),
            'create' => Pages\CreateMonitoringPerawatan::route('/create'),
            'edit' => Pages\EditMonitoringPerawatan::route('/{record}/edit'),
        ];
    }
}

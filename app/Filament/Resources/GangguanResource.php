<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GangguanResource\Pages;
use App\Filament\Resources\GangguanResource\RelationManagers;
use App\Models\Gangguan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DateTimePicker;
use App\Models\Lrv;

class GangguanResource extends Resource
{
    protected static ?string $model = Gangguan::class;

    protected static ?string $title = 'Gangguan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Gangguan';
    protected static ?int $navigationSort = 10;
    protected static ?string $slug = 'gangguan';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        $lrvOptions = LRV::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->lrv . ' | ' . $item->nomor_ka];
        });
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('tgl_gangguan')
                    ->label('Tanggal Gangguan')
                    ->default(now())
                    ->required(),
                Forms\Components\DateTimePicker::make('action_date')
                    ->label('Action Date')
                    ->default(now())
                    ->required(),
                Forms\Components\DateTimePicker::make('close_date')
                    ->label('Close Date')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('lrv_id')
                    ->relationship('lrv', 'lrv')
                    ->options($lrvOptions)
                    ->label('LRV')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('kabin')
                    ->label('Kabin')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('informasi_gangguan')
                    ->label('Asal Informasi Gangguan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sistem_utama')
                    ->label('Sistem Utama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('perangkat_spesifik')
                    ->label('Perangkat Spesifik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('deskripsi_fault')
                    ->label('Deskripsi Fault')
                    ->maxLength(255),
                Forms\Components\TextInput::make('service_request')
                    ->label('Service Request (Maximo)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_maximo')
                    ->label('Status Pada Maximo')
                    ->maxLength(255),

                Forms\Components\TextInput::make('status_action')
                    ->label('Status Action')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tindak_lanjut')
                    ->label('Tindak Lanjut')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penggunaan_sparepart')
                    ->label('Penggunaan Sparepart')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keterangan')
                    ->label('Closure Remarks')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->color('warning'),
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
            'index' => Pages\ListGangguans::route('/'),
            'create' => Pages\CreateGangguan::route('/create'),
            'edit' => Pages\EditGangguan::route('/{record}/edit'),
        ];
    }
}

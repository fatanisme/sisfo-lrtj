<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Equipment;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PerawatanEquipment;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PerawatanEquipmentResource\Pages;
use App\Filament\Resources\PerawatanEquipmentResource\RelationManagers;

class PerawatanEquipmentResource extends Resource
{
    protected static ?string $model = PerawatanEquipment::class;
    protected static ?string $title = 'Perawatan Equipment';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Perawatan Equipment';
    protected static ?int $navigationSort = 11;
    protected static ?string $slug = 'perawatanequipment';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\DatePicker::make('tgl_perawatan')
                    ->label('Tanggal Perawatan')
                    ->default(now())
                    ->required(),

                Forms\Components\Select::make('jenis_perawatan')
                    ->options([
                        'Perawatan harian' => 'Perawatan harian',
                        'Perawatan Mingguan' => 'Perawatan Mingguan',
                        'Perawatan Bulanan' => 'Perawatan Bulanan',
                        'Perawatan 3 bulanan' => 'Perawatan 3 bulanan',
                        'Perawatan 6 bulanan' => 'Perawatan 6 bulanan',
                        'Perawatan 1 tahunan' => 'Perawatan 1 tahunan'
                    ])
                    ->label('Jenis Perawatan')
                    ->autofocus()
                    ->required(),
                Forms\Components\Select::make('equipment_id')
                    ->relationship('equipment', 'equipment')
                    ->options(Equipment::all()->pluck('equipment', 'id'))
                    ->searchable()
                    ->label('Equipment')
                    ->required(),
            ]);
    }
    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_perawatan')->date('d-F-Y')->sortable(),
                Tables\Columns\TextColumn::make('jenis_perawatan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('equipment.equipment')->sortable()->searchable(),
            ])
            ->filters(
                [
                    Filter::make('created_between')
                        ->form([
                            DatePicker::make('created_from')
                                ->label('Dari Tanggal'),
                            DatePicker::make('created_until')
                                ->label('Sampai Tanggal'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when($data['created_from'], fn ($query, $date) => $query->whereDate('tgl_perawatan', '>=', $date))
                                ->when($data['created_until'], fn ($query, $date) => $query->whereDate('tgl_perawatan', '<=', $date));
                        }),
                ]
            )

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
            'index' => Pages\ListPerawatanEquipment::route('/'),
            'create' => Pages\CreatePerawatanEquipment::route('/create'),
            'edit' => Pages\EditPerawatanEquipment::route('/{record}/edit'),
        ];
    }
}

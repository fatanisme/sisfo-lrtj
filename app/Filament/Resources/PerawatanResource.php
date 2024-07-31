<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\Lrv;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Perawatan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PerawatanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PerawatanResource\RelationManagers;

class PerawatanResource extends Resource
{
    protected static ?string $model = Perawatan::class;

    protected static ?string $title = 'Perawatan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Perawatan';
    protected static ?int $navigationSort = 10;
    protected static ?string $slug = 'perawatan';
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

                Forms\Components\Select::make('jenis_perawatan')
                    ->options([
                        'Periodik 3 harian' => 'Periodik 3 harian',
                        'Periodik 7 harian' => 'Periodik 7 harian',
                        'Periodik 4 bulanan' => 'Periodik 4 bulanan',
                        'Periodik 1 tahunan' => 'Periodik 1 tahunan',
                        'Periodik 4 tahunan' => 'Periodik 4 tahunan',
                        'Periodik 8 tahunan' => 'Periodik 8 tahunan'
                    ])
                    ->label('Jenis Perawatan')
                    ->autofocus()
                    ->required(),
                Forms\Components\Select::make('lrv_id')
                    ->relationship('lrv', 'lrv')
                    ->options($lrvOptions)
                    ->searchable()
                    ->label('LRV')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_perawatan')->date('d-F-Y')->sortable(),
                Tables\Columns\TextColumn::make('jenis_perawatan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lrv.lrv')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lrv.nomor_ka')->label('Nomor KA')->sortable()->searchable(),
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
            'index' => Pages\ListPerawatans::route('/'),
            'create' => Pages\CreatePerawatan::route('/create'),
            'edit' => Pages\EditPerawatan::route('/{record}/edit'),
        ];
    }
}

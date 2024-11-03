<?php

namespace App\Filament\Resources;

use DateTime;
use App\Models\Lrv;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pendinasan;
use Filament\Tables\Table;
use App\Models\Stamformasi;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StamformasiResource\Pages;
use App\Filament\Resources\StamformasiResource\RelationManagers;

class StamformasiResource extends Resource
{
    protected static ?string $model = Stamformasi::class;
    protected static ?string $label = 'Status LRV';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Status LRV';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        $lrvOptions = LRV::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->lrv . ' | ' . $item->nomor_ka];
        })->prepend('Pilih LRV | Nomor Trainset', '');

        $userId = Auth()->id();
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tgl_stamformasi')
                    ->label('Tanggal Stamformasi')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label('Location')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\Select::make('lrv_id')
                    ->relationship('lrv', 'lrv')
                    ->options($lrvOptions)
                    ->searchable()
                    ->label('LRV')
                    ->required(),
                Forms\Components\Select::make('status_pendinasan')
                    ->options([
                        'Siap Operasi' => 'Siap Operasi',
                        'Cadangan' => 'Cadangan',
                        'Tidak Siap Operasi' => 'Tidak Siap Operasi',
                        'Periodik 3 harian' => 'Periodik 3 harian',
                        'Periodik 7 harian' => 'Periodik 7 harian',
                        'Periodik 4 bulanan' => 'Periodik 4 bulanan',
                        'Periodik 1 tahunan' => 'Periodik 1 tahunan',
                        'Periodik 4 tahunan' => 'Periodik 4 tahunan',
                        'Periodik 8 tahunan' => 'Periodik 8 tahunan',
                    ])
                    ->label('Status Pendinasan')
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255)
                    ->autofocus(),
                Forms\Components\Hidden::make('user_id')->default($userId),
                Forms\Components\Hidden::make('last_modified')->default(Carbon::now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_stamformasi')->date('d-F-Y')->sortable(),
                Tables\Columns\TextColumn::make('lrv.lrv')->label('LRV')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lrv.nomor_ka')->label('Nomor Trainset')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status_pendinasan')->sortable()->searchable()->badge()->color(fn(string $state): string => match ($state) {
                    'Tidak Siap Operasi' => 'danger',
                    'Siap Operasi' => 'success',
                    'Cadangan' => 'success',
                    default => 'warning',
                }),
                Tables\Columns\TextColumn::make('user.name')->label('Created By')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('last_modified')->date('d-m-Y H:m:s')->label('Last Modified')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan')->sortable()->searchable(),
            ])
            ->filters([
                Filter::make('created_between')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn($query, $date) => $query->whereDate('tgl_stamformasi', '>=', $date))
                            ->when($data['created_until'], fn($query, $date) => $query->whereDate('tgl_stamformasi', '<=', $date));
                    }),
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
            'index' => Pages\ListStamformasis::route('/'),
            'create' => Pages\CreateStamformasi::route('/create'),
            'edit' => Pages\EditStamformasi::route('/{record}/edit'),
        ];
    }
}

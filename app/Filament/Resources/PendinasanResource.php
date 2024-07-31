<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\Lrv;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Perawatan;
use App\Models\Pendinasan;
use Filament\Tables\Table;
use App\Models\Stamformasi;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PendinasanResource\Pages;
use App\Filament\Resources\PendinasanResource\RelationManagers;

class PendinasanResource extends Resource
{
    protected static ?string $model = Pendinasan::class;

    protected static ?string $title = 'Pendinasan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pendinasan';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'pendinasan';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        $lrvOptions = LRV::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->lrv . ' | ' . $item->nomor_ka];
        });

        return $form
            ->schema([
                Forms\Components\DatePicker::make('tgl_pendinasan')
                    ->label('Tanggal Pendinasan')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('lrv_id')
                    ->relationship('lrv', 'lrv')
                    ->options($lrvOptions)
                    ->label('LRV')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $tglPendinasan = Carbon::createFromFormat('Y-m-d', $get('tgl_pendinasan'));
                        if (Perawatan::select('jenis_perawatan')->where('lrv_id', $get('lrv_id'))->whereDate('tgl_perawatan', $tglPendinasan)->where('jenis_perawatan', 'Periodik 3 harian')->first()) {
                            $set('status_pendinasan', 'Periodik 3 harian');
                        } elseif (Perawatan::select('jenis_perawatan')->where('lrv_id', $get('lrv_id'))->whereDate('tgl_perawatan', $tglPendinasan)->where('jenis_perawatan', 'Periodik 7 harian')->first()) {
                            $set('status_pendinasan', 'Periodik 7 harian');
                        } elseif (Perawatan::select('jenis_perawatan')->where('lrv_id', $get('lrv_id'))->whereDate('tgl_perawatan', $tglPendinasan)->where('jenis_perawatan', 'Periodik 4 bulanan')->first()) {
                            $set('status_pendinasan', 'Periodik 4 bulanan');
                        } elseif (Perawatan::select('jenis_perawatan')->where('lrv_id', $get('lrv_id'))->whereDate('tgl_perawatan', $tglPendinasan)->where('jenis_perawatan', 'Periodik 1 tahunan')->first()) {
                            $set('status_pendinasan', 'Periodik 1 tahunan');
                        } elseif (Perawatan::select('jenis_perawatan')->where('lrv_id', $get('lrv_id'))->whereDate('tgl_perawatan', $tglPendinasan)->where('jenis_perawatan', 'Periodik 4 tahunan')->first()) {
                            $set('status_pendinasan', 'Periodik 4 tahunan');
                        } elseif (Perawatan::select('jenis_perawatan')->where('lrv_id', $get('lrv_id'))->whereDate('tgl_perawatan', $tglPendinasan)->where('jenis_perawatan', 'Periodik 8 tahuanan')->first()) {
                            $set('status_pendinasan', 'Periodik 8 tahunan');
                        } else {
                            // Suggested code may be subject to a license. Learn more: ~LicenseLog:3803613136.
                            $set('status_pendinasan', '');
                        }
                    }),
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

                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        if ($get('status_pendinasan') === 'Siap Operasi') {
                            $set('location', 'Mainline');
                        } else {
                            // Suggested code may be subject to a license. Learn more: ~LicenseLog:3803613136.
                            $set('location', '');
                        }
                    }),
                Forms\Components\TextInput::make('location')
                    ->label('Location')
                    ->maxLength('256')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_pendinasan')->sortable()->date('d-F-Y'),
                Tables\Columns\TextColumn::make('lrv.lrv')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lrv.nomor_ka')->label('Nomor KA')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status_pendinasan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('location')->sortable()->searchable(),
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
                            ->when($data['created_from'], fn ($query, $date) => $query->whereDate('tgl_pendinasan', '>=', $date))
                            ->when($data['created_until'], fn ($query, $date) => $query->whereDate('tgl_pendinasan', '<=', $date));
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
            'index' => Pages\ListPendinasans::route('/'),
            'create' => Pages\CreatePendinasan::route('/create'),
            'edit' => Pages\EditPendinasan::route('/{record}/edit'),
        ];
    }
}

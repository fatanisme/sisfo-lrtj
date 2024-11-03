<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LRVResource\Pages;
use App\Filament\Resources\LRVResource\RelationManagers;
use App\Models\Lrv;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LRVResource extends Resource
{
    protected static ?string $model = Lrv::class;

    protected static ?string $title = 'LRV';

    protected static ?string $navigationIcon = 'ionicon-train-outline';
    protected static ?string $navigationLabel = 'LRV';
    protected static ?string $slug = 'lrv';
    protected static ?string $navigationGroup = 'Master';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lrv')
                    ->label('LRV')
                    ->autofocus()
                    ->required(),
                Forms\Components\TextInput::make('nomor_ka')
                    ->label('Nomor Trainsets')
                    ->autofocus()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lrv')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nomor_ka')->label('Nomor Trainset')->sortable()->searchable(),
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
            'index' => Pages\ListLRVS::route('/'),
            'create' => Pages\CreateLRV::route('/create'),
            'edit' => Pages\EditLRV::route('/{record}/edit'),
        ];
    }
}

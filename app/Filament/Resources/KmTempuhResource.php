<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KmTempuhResource\Pages;
use App\Filament\Resources\KmTempuhResource\RelationManagers;
use App\Models\KmTempuh;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Lrv;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class KmTempuhResource extends Resource
{
    protected static ?string $model = KmTempuh::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'KM Tempuh';
    protected static ?string $navigationGroup = 'Master Data';

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        $userId = Auth::id();

        return $form
            ->schema([
                Forms\Components\TextInput::make('status_lrv')
                    ->label('Status LRV')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Forms\Components\Select::make('lrv_id')
                    ->relationship('lrv', 'lrv')
                    ->options(Lrv::all()->pluck('lrv', 'id'))
                    ->searchable()
                    ->label('LRV')
                    ->required(),
                Forms\Components\Hidden::make('user_id')->default($userId),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lrv.lrv')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status_lrv')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('updated_at')->sortable()->searchable(),
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
            'index' => Pages\ListKmTempuhs::route('/'),
            'create' => Pages\CreateKmTempuh::route('/create'),
            'edit' => Pages\EditKmTempuh::route('/{record}/edit'),
        ];
    }
}

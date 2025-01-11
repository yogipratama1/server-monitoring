<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpaceDetailResource\Pages;
use App\Filament\Resources\SpaceDetailResource\RelationManagers;
use App\Models\SpaceDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpaceDetailResource extends Resource
{
    protected static ?string $model = SpaceDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lokasi_id')
                    ->label('Nama Lokasi') // Label di form
                    ->relationship('lokasi', 'nama_lokasi') // Relasi ke model Lokasi
                    ->searchable() // Tambahkan pencarian
                    ->required(),
                Forms\Components\TextInput::make('total_space')
                    ->maxLength(255),
                Forms\Components\TextInput::make('used_space')
                    ->maxLength(255),
                Forms\Components\TextInput::make('free_space')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lokasi.nama_lokasi') // Relasi ke nama lokasi
                    ->label('Nama Lokasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_space')
                    ->searchable(),
                Tables\Columns\TextColumn::make('used_space')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('free_space')
                    ->label('Free Space')
                    ->sortable()
                    // ->formatStateUsing(fn($state) => $state . ' GB') // Format tampilan nilai
                    ->colors([
                        'danger' => fn($state) => (float) str_replace(' GB', '', $state) < 5, // Merah untuk kurang dari 5 GB
                        'warning' => fn($state) => (float) str_replace(' GB', '', $state) < 10, // Kuning untuk kurang dari 10 GB
                        'success' => fn($state) => (float) str_replace(' GB', '', $state) >= 10, // Hijau untuk lebih dari 10 GB
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListSpaceDetails::route('/'),
            'create' => Pages\CreateSpaceDetail::route('/create'),
            'edit' => Pages\EditSpaceDetail::route('/{record}/edit'),
        ];
    }
}

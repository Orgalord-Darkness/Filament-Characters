<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharacterResource\Pages;
use App\Filament\Resources\CharacterResource\RelationManagers;
use App\Models\Character;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select ; 
use Filament\Tables\Columns\TextColumn;

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')->required(), 
                Forms\Components\TextInput::make('lastname')->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\TextInput::make('aptitude')->required(),
                Forms\Components\TextInput::make('role')->required(),
                Select::make('classe_id')
                ->relationship('classe', 'name')
                ->required(),  //c'est le classe du model pas le nom de la table
                Select::make('grade_id')
                ->relationship('grade', 'libelle')
                ->required(),  //c'est le classe du model pas le nom de la table
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname'),
                Tables\Columns\TextColumn::make('lastname'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('aptitude'),
                Tables\Columns\TextColumn::make('role'),
                TextColumn::make('classe.name')
                ->label('Classe')   
                ->sortable()
                ->searchable(),
                TextColumn::make('grade.libelle')
                ->label('Grade')
                ->formatStateUsing(function ($state) { 
                    return ucfirst($state); 
                })
                ->color(function ($state){
                    return $state === 'Soldat' ? 'bg-grey-500' :
                    ($state === 'Recrue' ? 'text-blue-500': 'text-red-500' );  
                }),
                // ->html(),
                // ->formatStateUsing(function($state){
                //     return ucfirst($state); 
                // })
                // ->color(function ($record){
                //     return $record->status && $record->status->text_color ? $record->status->text_color : 'text-grey-500'; 
                // })
                // ->extraAttributes(function ($record){
                //     return $record->status && $record->status->color ? [ 'style' =>"background-color : {$record->status->color};",
                //     ] : []; 
                // }),
                // ->sortable()
                // ->searchable(),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCharacters::route('/'),
            'create' => Pages\CreateCharacter::route('/create'),
            'edit' => Pages\EditCharacter::route('/{record}/edit'),
        ];
    }
}

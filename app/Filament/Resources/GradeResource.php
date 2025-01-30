<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Filament\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn ; 
use App\Filament\Resources\GradeResource\Pages\GradeFilters ;
use Filament\Tables\Enums\FiltersLayout;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('libelle')->required(), 
                Forms\Components\TextInput::make('abilitation')->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\ColorPicker::make('color')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('libelle')
                    ->label('Libelle') 
                    ->formatStateUsing(function ($state) { 
                        return ucfirst($state); 
                    })
                    ->color('red')
                    ->extraAttributes(function ($state) {
                        return [
                           'style' => 'background-color: ' . Grade::getColorByLibelle($state) . '; color: '
                           .Grade::getColorTextByLibelle($state).' !important ;',
                        ];
                    }),
                TextColumn::make('color')
                    ->label('Couleur')    
                    ->formatStateUsing(function ($state) { 
                        return "<span style='background-color:  {$state} ; padding 2px 5px ; border-radius:3px;'>
                        {$state}</span>" ;  
                    })
                    ->html(),
                TextColumn::make('text_color')
                    ->label('Couleur de texte')
                    ->formatStateUsing(function ($state){
                        return "<span style='color : {$state} ; '>{$state}</span>" ; 
                    })
                    ->html(), 

                    // ->extraAttributes(function ($record){
                    //     return [
                    //         'style' => "background-color : {$record->status->color};", 
                    //     ]; 
                    // }), 
                Tables\Columns\TextColumn::make('abilitation')
                ->sortable(),
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters(GradeFilters::getFilters(), layout: FiltersLayout::AboveContent)
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
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}

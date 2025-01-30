<?php 
namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class ClasseColumns
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),
            TextColumn::make('name')
                ->label('Nom')
                ->sortable()
                ->searchable(),
            TextColumn::make('description')
                ->label('Description')
                ->limit(50),
            TextColumn::make('created_at')
                ->label('Date de création')
                ->dateTime(),
        ];
    }
}
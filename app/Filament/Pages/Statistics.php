<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Resources\CharacterResource\Widgets\CharacterOverview; 
use App\Filament\Widgets\CharactersClasseChart; 
use App\Filament\Widgets\CharactersGradeChart; 

class Statistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.statistics';

    protected function getHeaderWidgets(): array
    {
        return [
            CharacterOverview::class, 
            CharactersClasseChart::class, 
            CharactersGradeChart::class, 
        ]; 
    }
}
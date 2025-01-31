<?php

namespace App\Filament\Resources\CharacterResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Classe ; 
use App\Models\Character ; 
use App\Models\Grade; 

class CharacterOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = []; 
        $classes = Classe::withCount('characters')->get();
        $character = Character::count(); 
        $classe = Classe::count(); 
        $grade = Grade::count(); 

        foreach($classes as $row){
            $stats[] = Stat::make($row->name, $row->characters_count) 
                ->description('Nombre personnages pour la classe '.$row->name)
                ->descriptionIcon(''); 
        } 
        $stats[] = Stat::make('Total de personnage : ', $character);
        $stats[] = Stat::make('Total de classe : ', $classe);
        $stats[] = Stat::make('Total de grade : ', $grade);
        return $stats; 
    }
}

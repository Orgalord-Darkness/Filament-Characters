<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Grade; 
use App\Models\Character; 

class CharactersGradeChart extends ChartWidget
{
    protected static ?string $heading = 'Nombre de personnages par grade';

    protected function getData(): array
    {
        $classes = Grade::withCount('characters')->get();

        $labels = $classes->pluck('libelle')->toArray(); 
        $data = $classes->pluck('characters_count')->toArray(); 
        return [
            'datasets' => [  
                [          
                    'label' =>'Statistique des personnages par classe', 
                    'data' => $data, 
                    'backgroundColor'=>

                    [
                        "#FF0000",
                        "#00FF00",
                        "#0000FF",
                        "#FFFF00",
                        "#00FFFF",
                        "#FF00FF",
                        "#000000",
                        "#FFFFFF",
                        "#808080",
                        "#FFA500"
                    ], 
                    'borderColor'=> 
                    [
                        "#8B0000",    // DarkRed
                        "#006400",     // DarkGreen
                        "#00008B",     // DarkBlue
                        "#9B870C",    // DarkGoldenrod
                        "#008B8B",     // DarkCyan
                        "#8B008B",  // DarkMagenta
                        "#000000",     // Black (no darker version)
                        "#A9A9A9",    // DarkGray
                        "#696969",     // DimGray
                        "#FF8C00"    // DarkOrange
                    ] 
                ],
            ],
            'labels' => $labels 
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}

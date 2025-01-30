<?php 
namespace App\Filament\Resources\CharacterResource\Pages ; 

use App\Models\Character ; 
use App\Models\Classe ; 
use App\Models\Grade ; 
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class CharacterFilters 
{
    public static function getFilters(): array 
    {
        return [
            Filter::make('id')
            ->form([
                TextInput::make('id')->label('N°')
                ->numeric()
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query 
                ->when($data['id'], fn (Builder $query, $id): Builder => $query->where('id',$id)); 
            }), 
            SelectFilter::make('Grade')
                    ->options( function () {
                        $grades = Grade::all() ; //Récupérer toutes les valeurs de la table via all pour faire le tableu options
                        $options = [] ; 
                        foreach($grades as $row){
                            if($row->libelle != null){
                                $options[$row->id] = $row->libelle ; 
                            } 
                        }
                        return $options ; 
                    })
                ->attribute('grade_id'),

                SelectFilter::make('Classe')
                    ->options( function () {
                        $classes = Classe::all() ; 
                        $options = [] ; 
                        foreach($classes as $row){
                            if($row->name != null){
                                $options[$row->id] = $row->name ; 
                            }
                        }   
                        return $options ; 
                    })
                    ->attribute('classe_id'),
                Filter::make('created_at')
                ->form([
                    DatePicker::make('date_debut')->label('Date de création du :')
                        ->displayFormat('d M Y')
                        ->native(false),

                    DatePicker::make('date_fin')->label('au')
                        ->displayFormat('d M Y')
                        ->native(false)
                ])->columns(2)
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['date_debut'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                        ->when($data['date_fin'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                }),

            // SelectFilter::make('type_entree')->label('Type d\'entrée')
            //     ->options(function (): array {
            //         return Parametre::where('champ_id',1)->orderBy('ordre','ASC')->get()->pluck('libelle','libelle')->toArray();
            //     }),

            // Filter::make('num_3977')
            //     ->form([TextInput::make('num_3977')->label('N° 3977')])
            //     ->query(function (Builder $query, array $data): Builder {
            //         return $query
            //         ->when($data['num_3977'], fn (Builder $query, $num_3977): Builder => $query->where('num_3977', $num_3977));
            //     }),

            // SelectFilter::make('nom_etab')->label('ESSMS')
            //     ->searchable()
            //     ->options(function (EtabRepository $etabRepository): array {
            //         return $etabRepository->getEtabs()->pluck('nom','nom')->toArray();
            //     })
        ];
    }
}
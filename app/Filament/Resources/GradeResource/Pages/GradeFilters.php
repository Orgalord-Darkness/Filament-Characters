<?php 
namespace App\Filament\Resources\GradeResource\Pages ; 

use App\Models\Classe ; 
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker; 

class GradeFilters 
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
            
            Filter::make('libelle')
            ->form([
                TextInput::make('libelle')->label('Libelle :')
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query 
                ->when($data['libelle'], fn (Builder $query, $libelle): Builder => $query->where('libelle',$libelle)); 
            }), 
            
            Filter::make('color')
            ->form([
                ColorPicker::make('color')->label('Color : ')
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query 
                ->when($data['color'], fn (Builder $query, $color): Builder => $query->where('color',$color)); 
            }), 
            
            Filter::make('text_color')
            ->form([
                ColorPicker::make('text_color')->label('Color of text: ')
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query 
                ->when($data['text_color'], fn (Builder $query, $color): Builder => $query->where('text_color',$color)); 
            }), 
            
            Filter::make('abilitation')
            ->form([
                TextInput::make('abilitation')->label('Abilitation :')
                ->numeric()
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query 
                ->when($data['abilitation'], fn (Builder $query, $abilitation): Builder => $query->where('abilitation',$abilitation)); 
            }),
            
            Filter::make('description')
            ->form([
                TextInput::make('description')->label('Description :')
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query 
                ->when($data['description'], fn (Builder $query, $description): Builder => $query->where('description',$description)); 
            }),

            Filter::make('created_at')
                ->form([
                    DatePicker::make('date_debut')->label('Date réception du')
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

        ];
    }
}
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
use Filament\Tables\Filters\Filter ; //use pour filtre filament
use Filament\Tables\Filters\SelectFilter;
use App\Models\Grade ; 
use App\Models\Classe ; 
use Filament\Support\Facades\FilamentColor; 
use Filament\Support\Colors\Color ; 
use pxlrbt\FilamentExcel\Columns\Column ; 
use pxlrbt\FilamentExcel\Exports\ExcelExport ; 
use App\Filament\Exports\CharacterExporter; //exporter une entité -> générer avec make:filament-exporter NomEntite --generate 
use Filament\Actions\ExportAction ; 
use Filament\Tables\Actions\ExportBulkAction; 
use Filament\Actions\Exports\Enums\ExportFormat ; 
use Filament\Actions\Exports\Models\Export ; 
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction; 
use Filament\Tables\Actions\EditAction ; 
use Filament\Tables\Actions\DeleteAction ; 


class CharacterResource extends Resource
{    
    // Récupérer les grades depuis la base de données
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
                Tables\Columns\TextColumn::make('firstname')
                    ->wrap() // attribut pour réduire la longueur de la colonne
                    ->sortable() //attribut pour trier par ordre croissant / décroissant
                    ->searchable(), //attribut pour ajouter le champ à la barre de recherche généré automatiquement 
                Tables\Columns\TextColumn::make('lastname')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->color('red_text')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aptitude')
                ->wrap()
                ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                ->wrap()
                ->searchable()
                ->extraAttributes(['style' =>'color: blue !important ; ',])
                    ->sortable(),
                TextColumn::make('classe.name')
                ->wrap()
                    ->label('Classe')   
                    ->sortable()
                    ->searchable(),
                TextColumn::make('grade.libelle')
                    ->wrap()
                    ->label('Grade')
                    ->sortable()
                    ->searchable()
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
                // Tables\Columns\TextColumn::make('created_at'),
                // Tables\Columns\TextColumn::make('updated_at'),

            ])
            ->filters([
                //
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),   
                    ExportBulkAction::make()
                    ->exporter(CharacterExporter::class)
                    ->formats([
                        ExportFormat::Csv,
                    ])
                    ->fileName(fn (Export $export): string => "products-{$export->getKey()}.csv")
                    //->directDownload() // Pour télécharger directement sans afficher de modal
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
                    ->fileDisk('s3')

                ]),
            ])
            // ->headerActions([
            //     ExportAction::make()
            //      ->exporter(CharacterExporter::class)
            //      ->formats([
            //          ExportFormat::Csv,  
            //      ])
            //      ->fileName(fn (Export $export): string => "products-{$export->getKey()}.csv")
         
            //      ])
            ;
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

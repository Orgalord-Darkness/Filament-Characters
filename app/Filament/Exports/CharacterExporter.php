<?php

namespace App\Filament\Exports;

use App\Models\Character;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CharacterExporter extends Exporter
{
    protected static ?string $model = Character::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('firstname'),
            ExportColumn::make('lastname'),
            ExportColumn::make('description'),
            ExportColumn::make('aptitude'),
            ExportColumn::make('role'),
            ExportColumn::make('classe.name'),
            ExportColumn::make('grade.libelle'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your character export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "products-{$export->getKeys()}.csv" ; 
    }

    // public function export($query)
    // {
    //     // Logique pour exporter les données
    //     // Par exemple, vous pouvez utiliser SimpleExcel pour créer un fichier CSV
    //     $rows = $query->get()->toArray();

    //     $csv = \SimpleExcel\SimpleExcel::create('csv');
    //     $csv->writer()->addRows($rows);
    //     $csv->save(storage_path('app/exports/products.csv'));

    //     return $csv->getPath();
    // }
}

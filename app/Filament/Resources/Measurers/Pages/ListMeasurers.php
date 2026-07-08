<?php

namespace App\Filament\Resources\Measurers\Pages;

use App\Filament\Resources\Measurers\MeasurerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeasurers extends ListRecords
{
    protected static string $resource = MeasurerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

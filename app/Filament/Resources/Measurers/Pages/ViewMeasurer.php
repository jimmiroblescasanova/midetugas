<?php

namespace App\Filament\Resources\Measurers\Pages;

use App\Filament\Resources\Measurers\MeasurerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeasurer extends ViewRecord
{
    protected static string $resource = MeasurerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

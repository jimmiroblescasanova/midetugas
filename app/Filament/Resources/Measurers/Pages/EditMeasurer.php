<?php

namespace App\Filament\Resources\Measurers\Pages;

use App\Filament\Resources\Measurers\MeasurerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMeasurer extends EditRecord
{
    protected static string $resource = MeasurerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

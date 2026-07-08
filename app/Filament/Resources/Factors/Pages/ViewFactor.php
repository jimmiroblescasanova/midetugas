<?php

namespace App\Filament\Resources\Factors\Pages;

use App\Filament\Resources\Factors\FactorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFactor extends ViewRecord
{
    protected static string $resource = FactorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

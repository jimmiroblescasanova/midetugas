<?php

namespace App\Filament\Resources\Factors\Pages;

use App\Filament\Resources\Factors\FactorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFactors extends ListRecords
{
    protected static string $resource = FactorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

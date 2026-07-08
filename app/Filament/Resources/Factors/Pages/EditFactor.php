<?php

namespace App\Filament\Resources\Factors\Pages;

use App\Filament\Resources\Factors\FactorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFactor extends EditRecord
{
    protected static string $resource = FactorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

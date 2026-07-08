<?php

namespace App\Filament\Resources\Factors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FactorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('psig')
                    ->required(),
                TextInput::make('value')
                    ->required(),
            ]);
    }
}

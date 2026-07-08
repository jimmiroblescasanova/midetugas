<?php

namespace App\Filament\Resources\Measurers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MeasurerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('brand')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                TextInput::make('serial_number')
                    ->required(),
                TextInput::make('actual_measure')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('correction_factor')
                    ->required()
                    ->default('1'),
                Toggle::make('active')
                    ->required(),
                TextInput::make('client_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('factor_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}

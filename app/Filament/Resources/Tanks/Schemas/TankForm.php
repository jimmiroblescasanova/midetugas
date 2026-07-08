<?php

namespace App\Filament\Resources\Tanks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TankForm
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
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('manufacturing_date')
                    ->required(),
                TextInput::make('project_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}

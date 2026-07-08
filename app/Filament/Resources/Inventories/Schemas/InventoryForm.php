<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date')
                    ->required(),
                TextInput::make('project_id')
                    ->required()
                    ->numeric(),
                TextInput::make('tank_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('user')
                    ->required(),
            ]);
    }
}

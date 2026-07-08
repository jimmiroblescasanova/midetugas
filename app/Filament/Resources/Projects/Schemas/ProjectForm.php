<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('reference')
                    ->default(null),
                TextInput::make('total_capacity')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('actual_capacity')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('percentage')
                    ->required()
                    ->numeric()
                    ->default(100),
            ]);
    }
}

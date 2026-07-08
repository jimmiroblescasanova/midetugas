<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date')
                    ->required(),
                TextInput::make('contract_number')
                    ->required(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                Textarea::make('tax_address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}

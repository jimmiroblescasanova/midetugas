<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('date')
                    ->required(),
                DateTimePicker::make('payment_date')
                    ->required(),
                TextInput::make('final_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('start_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('month_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('correction_factor')
                    ->required()
                    ->numeric(),
                TextInput::make('period')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('adm_charge')
                    ->required()
                    ->numeric(),
                TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reconnection')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('iva')
                    ->required()
                    ->numeric(),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                TextInput::make('pending')
                    ->required()
                    ->numeric(),
                TextInput::make('reference')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('photo')
                    ->required(),
            ]);
    }
}

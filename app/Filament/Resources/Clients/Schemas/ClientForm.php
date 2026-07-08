<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('shortName')
                    ->required(),
                TextInput::make('rfc')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('reference')
                    ->required(),
                TextInput::make('country_code')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('line_1')
                    ->default(null),
                TextInput::make('line_2')
                    ->default(null),
                TextInput::make('line_3')
                    ->default(null),
                TextInput::make('locality')
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('state_province')
                    ->default(null),
                TextInput::make('country')
                    ->default(null),
                TextInput::make('zipcode')
                    ->default(null),
                TextInput::make('ref1_name')
                    ->default(null),
                TextInput::make('ref1_phone')
                    ->tel()
                    ->default(null),
                TextInput::make('ref2_name')
                    ->default(null),
                TextInput::make('ref2_phone')
                    ->tel()
                    ->default(null),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('status')
                    ->required(),
                Toggle::make('reconnection_charge')
                    ->required(),
                TextInput::make('deposit')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('project_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('shortName'),
                TextEntry::make('rfc'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('reference'),
                TextEntry::make('country_code'),
                TextEntry::make('phone'),
                TextEntry::make('line_1')
                    ->placeholder('-'),
                TextEntry::make('line_2')
                    ->placeholder('-'),
                TextEntry::make('line_3')
                    ->placeholder('-'),
                TextEntry::make('locality')
                    ->placeholder('-'),
                TextEntry::make('city')
                    ->placeholder('-'),
                TextEntry::make('state_province')
                    ->placeholder('-'),
                TextEntry::make('country')
                    ->placeholder('-'),
                TextEntry::make('zipcode')
                    ->placeholder('-'),
                TextEntry::make('ref1_name')
                    ->placeholder('-'),
                TextEntry::make('ref1_phone')
                    ->placeholder('-'),
                TextEntry::make('ref2_name')
                    ->placeholder('-'),
                TextEntry::make('ref2_phone')
                    ->placeholder('-'),
                TextEntry::make('balance')
                    ->numeric(),
                IconEntry::make('status')
                    ->boolean(),
                IconEntry::make('reconnection_charge')
                    ->boolean(),
                TextEntry::make('deposit')
                    ->numeric(),
                TextEntry::make('project_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

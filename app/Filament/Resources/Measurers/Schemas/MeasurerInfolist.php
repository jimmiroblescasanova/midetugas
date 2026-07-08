<?php

namespace App\Filament\Resources\Measurers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MeasurerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('brand'),
                TextEntry::make('model'),
                TextEntry::make('serial_number'),
                TextEntry::make('actual_measure')
                    ->numeric(),
                TextEntry::make('correction_factor'),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('client_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('factor_id')
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

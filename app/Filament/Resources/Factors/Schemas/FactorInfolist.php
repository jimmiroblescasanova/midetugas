<?php

namespace App\Filament\Resources\Factors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FactorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('psig'),
                TextEntry::make('value'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

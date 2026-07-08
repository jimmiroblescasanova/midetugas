<?php

namespace App\Filament\Resources\Tanks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TankInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('brand'),
                TextEntry::make('model'),
                TextEntry::make('serial_number'),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('manufacturing_date')
                    ->dateTime(),
                TextEntry::make('project_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

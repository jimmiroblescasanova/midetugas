<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('date')
                    ->dateTime(),
                TextEntry::make('payment_date')
                    ->dateTime(),
                TextEntry::make('final_quantity')
                    ->numeric(),
                TextEntry::make('start_quantity')
                    ->numeric(),
                TextEntry::make('month_quantity')
                    ->numeric(),
                TextEntry::make('correction_factor')
                    ->numeric(),
                TextEntry::make('period'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('adm_charge')
                    ->numeric(),
                TextEntry::make('discount')
                    ->numeric(),
                TextEntry::make('reconnection')
                    ->numeric(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('iva')
                    ->numeric(),
                TextEntry::make('total')
                    ->numeric(),
                TextEntry::make('pending')
                    ->numeric(),
                TextEntry::make('reference')
                    ->numeric(),
                TextEntry::make('status')
                    ->numeric(),
                TextEntry::make('photo'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

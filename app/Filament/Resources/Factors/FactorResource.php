<?php

namespace App\Filament\Resources\Factors;

use App\Factor;
use App\Filament\Resources\Factors\Pages\CreateFactor;
use App\Filament\Resources\Factors\Pages\EditFactor;
use App\Filament\Resources\Factors\Pages\ListFactors;
use App\Filament\Resources\Factors\Pages\ViewFactor;
use App\Filament\Resources\Factors\Schemas\FactorForm;
use App\Filament\Resources\Factors\Schemas\FactorInfolist;
use App\Filament\Resources\Factors\Tables\FactorsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FactorResource extends Resource
{
    protected static ?string $model = Factor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FactorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FactorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FactorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFactors::route('/'),
            'create' => CreateFactor::route('/create'),
            'view' => ViewFactor::route('/{record}'),
            'edit' => EditFactor::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Measurers;

use App\Filament\Resources\Measurers\Pages\CreateMeasurer;
use App\Filament\Resources\Measurers\Pages\EditMeasurer;
use App\Filament\Resources\Measurers\Pages\ListMeasurers;
use App\Filament\Resources\Measurers\Pages\ViewMeasurer;
use App\Filament\Resources\Measurers\Schemas\MeasurerForm;
use App\Filament\Resources\Measurers\Schemas\MeasurerInfolist;
use App\Filament\Resources\Measurers\Tables\MeasurersTable;
use App\Measurer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MeasurerResource extends Resource
{
    protected static ?string $model = Measurer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MeasurerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MeasurerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurersTable::configure($table);
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
            'index' => ListMeasurers::route('/'),
            'create' => CreateMeasurer::route('/create'),
            'view' => ViewMeasurer::route('/{record}'),
            'edit' => EditMeasurer::route('/{record}/edit'),
        ];
    }
}

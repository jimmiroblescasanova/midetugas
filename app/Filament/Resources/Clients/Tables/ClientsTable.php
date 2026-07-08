<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('shortName')
                    ->searchable(),
                TextColumn::make('rfc')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('reference')
                    ->searchable(),
                TextColumn::make('country_code')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('line_1')
                    ->searchable(),
                TextColumn::make('line_2')
                    ->searchable(),
                TextColumn::make('line_3')
                    ->searchable(),
                TextColumn::make('locality')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('state_province')
                    ->searchable(),
                TextColumn::make('country')
                    ->searchable(),
                TextColumn::make('zipcode')
                    ->searchable(),
                TextColumn::make('ref1_name')
                    ->searchable(),
                TextColumn::make('ref1_phone')
                    ->searchable(),
                TextColumn::make('ref2_name')
                    ->searchable(),
                TextColumn::make('ref2_phone')
                    ->searchable(),
                TextColumn::make('balance')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('status')
                    ->boolean(),
                IconColumn::make('reconnection_charge')
                    ->boolean(),
                TextColumn::make('deposit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('project_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

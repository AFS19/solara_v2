<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('category.fields.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('category.fields.slug')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sort')
                    ->label('category.fields.sort')
                    ->translateLabel()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

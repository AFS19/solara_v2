<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('product.fields.name')
                    ->translateLabel()
                    ->searchable(),

                TextColumn::make('price')
                    ->label('product.fields.price')
                    ->translateLabel()
                    ->money('MAD')
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('order.fields.quantity')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('order.fields.subtotal')
                    ->translateLabel()
                    ->money('MAD')
                    ->sortable(),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

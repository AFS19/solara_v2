<?php

namespace App\Filament\Resources\Products\Tables;

use App\Settings\GeneralSettings;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        $currency = app(GeneralSettings::class)->currency;

        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('product.fields.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('product.fields.category')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('product.fields.price')
                    ->translateLabel()
                    ->money($currency)
                    ->sortable(),

                TextColumn::make('spf')
                    ->label('product.fields.spf')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),

                ToggleColumn::make('featured')
                    ->label('product.fields.featured')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),

                ToggleColumn::make('has_3d_model')
                    ->label('product.fields.has_3d_model')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('sort')
                    ->label('product.fields.sort')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Filter::make('featured')
                    ->label('product.fields.featured')
                    ->translateLabel()
                    ->query(fn (Builder $query): Builder => $query->where('featured', true)),
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

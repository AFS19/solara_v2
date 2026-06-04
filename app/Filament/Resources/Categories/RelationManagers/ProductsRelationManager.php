<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->label('product.fields.name')
                        ->translateLabel()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(1),

                    TextInput::make('slug')
                        ->label('product.fields.slug')
                        ->translateLabel()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText(__('product.helpers.slug'))
                        ->columnSpan(1),

                    TextInput::make('price')
                        ->label('product.fields.price')
                        ->translateLabel()
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->step(0.01)
                        ->columnSpan(1),

                    TextInput::make('spf')
                        ->label('product.fields.spf')
                        ->translateLabel()
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(150)
                        ->nullable()
                        ->helperText(__('product.helpers.spf'))
                        ->columnSpan(1),

                    Toggle::make('featured')
                        ->label('product.fields.featured')
                        ->translateLabel()
                        ->default(false)
                        ->helperText(__('product.helpers.featured'))
                        ->columnSpan(1),

                    Toggle::make('has_3d_model')
                        ->label('product.fields.has_3d_model')
                        ->translateLabel()
                        ->default(false)
                        ->helperText(__('product.helpers.has_3d_model'))
                        ->columnSpan(1),
                ]),

                Textarea::make('description')
                    ->label('product.fields.description')
                    ->translateLabel()
                    ->rows(4)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('product.fields.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('product.fields.price')
                    ->translateLabel()
                    ->money('MAD')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
            ]);
    }
}

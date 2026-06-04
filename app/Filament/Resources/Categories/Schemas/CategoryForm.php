<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('category.fields.details'))
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('category.fields.name')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('slug')
                                ->label('category.fields.slug')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->helperText(__('category.helpers.slug'))
                                ->columnSpan(1),

                            TextInput::make('sort')
                                ->label('category.fields.sort')
                                ->translateLabel()
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->helperText(__('category.helpers.sort'))
                                ->columnSpan(1),
                        ]),
                    ]),
            ]);
    }
}

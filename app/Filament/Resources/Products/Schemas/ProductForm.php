<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
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

                            Select::make('category_id')
                                ->label('product.fields.category')
                                ->translateLabel()
                                ->relationship('category', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
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
                    ]),

                Section::make('product.fields.media')
                    ->translateLabel()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->label('product.fields.images')
                            ->translateLabel()
                            ->collection('images')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->image()
                            ->maxFiles(10)
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('model_3d')
                            ->label('product.fields.model_3d')
                            ->translateLabel()
                            ->collection('model_3d')
                            ->maxFiles(1)
                            ->acceptedFileTypes([
                                'model/gltf-binary',
                                'application/octet-stream',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('rating')
                        ->label('reviews.fields.rating')
                        ->translateLabel()
                        ->options([
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                        ])
                        ->required(),

                    Textarea::make('comment')
                        ->label('reviews.fields.comment')
                        ->translateLabel()
                        ->rows(4)
                        ->maxLength(1000),

                    Select::make('is_approved')
                        ->label('reviews.fields.is_approved')
                        ->translateLabel()
                        ->options([
                            1 => trans('reviews.approved'),
                            0 => trans('reviews.pending'),
                        ])
                        ->required(),
                ]),
            ]);
    }
}

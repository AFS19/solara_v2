<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\Review;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->nullable(),

                Select::make('is_approved')
                    ->label('reviews.fields.is_approved')
                    ->translateLabel()
                    ->options([
                        1 => trans('reviews.approved'),
                        0 => trans('reviews.pending'),
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('reviews.fields.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('reviews.fields.email')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('rating')
                    ->label('reviews.fields.rating')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('reviews.fields.comment')
                    ->translateLabel()
                    ->limit(50),

                IconColumn::make('is_approved')
                    ->label('reviews.fields.is_approved')
                    ->translateLabel()
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('reviews.fields.created_at')
                    ->translateLabel()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),

                Action::make('approve')
                    ->label('reviews.actions.approve')
                    ->translateLabel()
                    ->requiresConfirmation()
                    ->action(fn (Review $record) => $record->update(['is_approved' => true]))
                    ->visible(fn (Review $record): bool => ! $record->is_approved),

                Action::make('reject')
                    ->label('reviews.actions.reject')
                    ->translateLabel()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Review $record) => $record->update(['is_approved' => false]))
                    ->visible(fn (Review $record): bool => $record->is_approved),
            ])
            ->toolbarActions([
                CreateAction::make(),
            ]);
    }
}

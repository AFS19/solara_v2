<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('reviews.fields.id')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('product.name')
                    ->label('reviews.fields.product')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

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
            ->filters([
                SelectFilter::make('is_approved')
                    ->label('reviews.filters.is_approved')
                    ->translateLabel()
                    ->options([
                        1 => trans('reviews.approved'),
                        0 => trans('reviews.pending'),
                    ]),

                SelectFilter::make('product')
                    ->label('reviews.filters.product')
                    ->translateLabel()
                    ->relationship('product', 'name'),
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\NewsletterSubscribers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsletterSubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('newsletter.fields.id')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('newsletter.fields.email')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('newsletter.fields.created_at')
                    ->translateLabel()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

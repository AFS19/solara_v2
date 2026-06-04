<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('order.fields.id')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('order.fields.email')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('order.fields.status')
                    ->translateLabel()
                    ->badge()
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('order.fields.payment_method')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('order.fields.payment_status')
                    ->translateLabel()
                    ->badge()
                    ->sortable(),

                TextColumn::make('total')
                    ->label('order.fields.total')
                    ->translateLabel()
                    ->money('MAD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('order.fields.created_at')
                    ->translateLabel()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('order.filters.status')
                    ->translateLabel()
                    ->options(OrderStatus::class),

                SelectFilter::make('payment_method')
                    ->label('order.filters.payment_method')
                    ->translateLabel()
                    ->options(PaymentMethod::class),

                Filter::make('date_range')
                    ->label('order.filters.date_range')
                    ->translateLabel()
                    ->form([
                        DatePicker::make('from')
                            ->label('order.filters.from')
                            ->translateLabel(),
                        DatePicker::make('to')
                            ->label('order.filters.to')
                            ->translateLabel(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['to'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('ship')
                    ->label('order.actions.ship')
                    ->translateLabel()
                    ->requiresConfirmation()
                    ->action(fn (Order $record) => $record->update(['status' => OrderStatus::Shipped]))
                    ->visible(fn (Order $record): bool => $record->status === OrderStatus::Pending || $record->status === OrderStatus::Processing),

                Action::make('deliver')
                    ->label('order.actions.deliver')
                    ->translateLabel()
                    ->requiresConfirmation()
                    ->action(fn (Order $record) => $record->update([
                        'status' => OrderStatus::Delivered,
                        'payment_status' => PaymentStatus::Paid,
                    ]))
                    ->visible(fn (Order $record): bool => $record->status === OrderStatus::Shipped),

                Action::make('cancel')
                    ->label('order.actions.cancel')
                    ->translateLabel()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Order $record) => $record->update(['status' => OrderStatus::Cancelled]))
                    ->visible(fn (Order $record): bool => $record->status !== OrderStatus::Delivered && $record->status !== OrderStatus::Cancelled),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

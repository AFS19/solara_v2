<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('order.fields.customer'))
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('email')
                                ->label('order.fields.email')
                                ->translateLabel()
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('phone')
                                ->label('order.fields.phone')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('first_name')
                                ->label('order.fields.first_name')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('last_name')
                                ->label('order.fields.last_name')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('address')
                                ->label('order.fields.address')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('city')
                                ->label('order.fields.city')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('postal_code')
                                ->label('order.fields.postal_code')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),
                        ]),
                    ]),

                Section::make(__('order.fields.status'))
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('order.fields.status')
                                ->translateLabel()
                                ->options(OrderStatus::class)
                                ->required()
                                ->columnSpan(1),

                            Select::make('payment_status')
                                ->label('order.fields.payment_status')
                                ->translateLabel()
                                ->options(PaymentStatus::class)
                                ->required()
                                ->columnSpan(1),
                        ]),
                    ]),
            ]);
    }
}

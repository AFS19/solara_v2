<?php

namespace App\Filament\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('email')
                        ->label('newsletter.fields.email')
                        ->translateLabel()
                        ->email()
                        ->required()
                        ->maxLength(255),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Settings\ContactSettings;
use App\Settings\ContentSettings;
use App\Settings\GeneralSettings;
use App\Settings\HeroSettings;
use App\Settings\SocialSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public function mount(): void
    {
        $general = app(GeneralSettings::class);
        $hero = app(HeroSettings::class);
        $contact = app(ContactSettings::class);
        $social = app(SocialSettings::class);
        $content = app(ContentSettings::class);

        $this->form->fill([
            'general_site_name' => $general->site_name,
            'general_currency' => $general->currency,
            'hero_source' => $hero->source,
            'hero_product_id' => $hero->product_id,
            'hero_media_path' => $hero->media_path,
            'contact_email' => $contact->email,
            'contact_phone' => $contact->phone,
            'contact_address' => $contact->address,
            'social_whatsapp' => $social->whatsapp,
            'social_facebook' => $social->facebook,
            'social_instagram' => $social->instagram,
            'social_tiktok' => $social->tiktok,
            'content_testimonials' => $content->testimonials,
            'content_about_stats' => $content->about_stats,
            'content_about_badges' => $content->about_badges,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Section::make('General')
                        ->schema([
                            TextInput::make('general_site_name')
                                ->label('Site Name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('general_currency')
                                ->label('Currency')
                                ->required()
                                ->maxLength(10)
                                ->default('MAD'),
                        ])
                        ->columns(2),

                    Section::make('Hero')
                        ->schema([
                            Select::make('hero_source')
                                ->label('Source')
                                ->options([
                                    'product' => 'Existing Product',
                                    'upload' => 'Upload Media',
                                ])
                                ->required()
                                ->live(),

                            Select::make('hero_product_id')
                                ->label('Product')
                                ->options(Product::query()->pluck('name', 'id'))
                                ->searchable()
                                ->visible(fn (Get $get): bool => $get('hero_source') === 'product'),

                            FileUpload::make('hero_media_path')
                                ->label('Media')
                                ->disk('supabase')
                                ->directory('hero')
                                ->acceptedFileTypes([
                                    'image/jpeg',
                                    'image/png',
                                    'image/webp',
                                    'model/gltf-binary',
                                    'application/octet-stream',
                                ])
                                ->visible(fn (Get $get): bool => $get('hero_source') === 'upload'),
                        ]),

                    Section::make('Contact')
                        ->schema([
                            TextInput::make('contact_email')
                                ->label('Email')
                                ->email()
                                ->required(),

                            TextInput::make('contact_phone')
                                ->label('Phone')
                                ->tel(),

                            TextInput::make('contact_address')
                                ->label('Address')
                                ->required(),
                        ]),

                    Section::make('Social Media')
                        ->schema([
                            TextInput::make('social_whatsapp')
                                ->label('WhatsApp Number')
                                ->prefixIcon('heroicon-m-chat-bubble-left-right'),

                            TextInput::make('social_facebook')
                                ->label('Facebook')
                                ->url()
                                ->prefixIcon('heroicon-m-globe-alt'),

                            TextInput::make('social_instagram')
                                ->label('Instagram')
                                ->url()
                                ->prefixIcon('heroicon-m-camera'),

                            TextInput::make('social_tiktok')
                                ->label('TikTok')
                                ->url()
                                ->prefixIcon('heroicon-m-video-camera'),
                        ])
                        ->columns(2),

                    Section::make('Content')
                        ->schema([
                            Repeater::make('content_testimonials')
                                ->label('Testimonials')
                                ->schema([
                                    TextInput::make('name')->required(),
                                    TextInput::make('loc')->required()->label('Location'),
                                    TextInput::make('product')->required(),
                                    TextInput::make('rating')
                                        ->required()
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(5)
                                        ->default(5),
                                    Textarea::make('text')->required()->rows(2)->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->collapsible(),

                            TextInput::make('content_about_stats')
                                ->label('About Stats')
                                ->required(),

                            TagsInput::make('content_about_badges')
                                ->label('About Badges')
                                ->required(),
                        ]),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save Changes')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $general = app(GeneralSettings::class);
        $general->site_name = $data['general_site_name'];
        $general->currency = $data['general_currency'];
        $general->save();

        $hero = app(HeroSettings::class);
        $hero->source = $data['hero_source'];
        $hero->product_id = $data['hero_source'] === 'product' ? $data['hero_product_id'] : null;
        $hero->media_path = $data['hero_source'] === 'upload' ? $data['hero_media_path'] : null;
        $hero->save();

        $contact = app(ContactSettings::class);
        $contact->email = $data['contact_email'];
        $contact->phone = $data['contact_phone'] ?: null;
        $contact->address = $data['contact_address'];
        $contact->save();

        $social = app(SocialSettings::class);
        $social->whatsapp = $data['social_whatsapp'] ?: null;
        $social->facebook = $data['social_facebook'] ?: null;
        $social->instagram = $data['social_instagram'] ?: null;
        $social->tiktok = $data['social_tiktok'] ?: null;
        $social->save();

        $content = app(ContentSettings::class);
        $content->testimonials = $data['content_testimonials'] ?: [];
        $content->about_stats = $data['content_about_stats'];
        $content->about_badges = $data['content_about_badges'] ?: [];
        $content->save();

        Notification::make()
            ->success()
            ->title('Saved')
            ->send();
    }
}

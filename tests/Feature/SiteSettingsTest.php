<?php

use App\Filament\Pages\ManageSiteSettings;
use App\Models\Product;
use App\Models\User;
use App\Settings\ContactSettings;
use App\Settings\ContentSettings;
use App\Settings\GeneralSettings;
use App\Settings\HeroSettings;
use App\Settings\SocialSettings;
use Livewire\Livewire;

it('loads settings with defaults', function () {
    expect(app(GeneralSettings::class)->site_name)->toBe('Sunscreen Store');
    expect(app(GeneralSettings::class)->currency)->toBe('MAD');
    expect(app(HeroSettings::class)->source)->toBe('product');
    expect(app(ContactSettings::class)->email)->toBe('contact@example.com');
    expect(app(SocialSettings::class)->facebook)->toBeNull();
    expect(app(ContentSettings::class)->testimonials)->toBeArray();
    expect(app(ContentSettings::class)->about_stats)->toBeString();
    expect(app(ContentSettings::class)->about_badges)->toBeArray();
});

it('requires auth for settings page', function () {
    $this->get('/admin/manage-site-settings')->assertRedirect('/admin/login');
});

it('renders settings page', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(ManageSiteSettings::class)
        ->assertSuccessful();
});

it('saves general settings', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(ManageSiteSettings::class)
        ->set('data.general_site_name', 'New Store Name')
        ->set('data.general_currency', 'USD')
        ->call('save')
        ->assertHasNoErrors();

    expect(app(GeneralSettings::class)->site_name)->toBe('New Store Name');
    expect(app(GeneralSettings::class)->currency)->toBe('USD');
});

it('saves hero product settings', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    Livewire::actingAs($user)->test(ManageSiteSettings::class)
        ->set('data.hero_source', 'product')
        ->set('data.hero_product_id', $product->id)
        ->call('save')
        ->assertHasNoErrors();

    $hero = app(HeroSettings::class);
    expect($hero->source)->toBe('product');
    expect($hero->product_id)->toBe($product->id);
    expect($hero->media_path)->toBeNull();
});

it('saves hero upload settings', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(ManageSiteSettings::class)
        ->set('data.hero_source', 'upload')
        ->set('data.hero_media_path', ['hero/test.glb'])
        ->call('save')
        ->assertHasNoErrors();

    $hero = app(HeroSettings::class);
    expect($hero->source)->toBe('upload');
    expect($hero->product_id)->toBeNull();
    expect($hero->media_path)->toBe('hero/test.glb');
});

it('saves contact and social settings', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(ManageSiteSettings::class)
        ->set('data.contact_email', 'hello@site.com')
        ->set('data.contact_phone', '+1234567890')
        ->set('data.contact_address', '123 Sun St')
        ->set('data.social_facebook', 'https://fb.com/test')
        ->set('data.social_whatsapp', '+212600000000')
        ->call('save')
        ->assertHasNoErrors();

    $contact = app(ContactSettings::class);
    expect($contact->email)->toBe('hello@site.com');
    expect($contact->phone)->toBe('+1234567890');
    expect($contact->address)->toBe('123 Sun St');

    $social = app(SocialSettings::class);
    expect($social->facebook)->toBe('https://fb.com/test');
    expect($social->whatsapp)->toBe('+212600000000');
});

it('saves content settings', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(ManageSiteSettings::class)
        ->set('data.content_about_stats', 'Test stats')
        ->set('data.content_about_badges', ['Badge 1', 'Badge 2'])
        ->set('data.content_testimonials', [
            ['name' => 'Test', 'loc' => 'City', 'product' => 'SPF 30', 'rating' => 5, 'text' => 'Great!'],
        ])
        ->call('save')
        ->assertHasNoErrors();

    $content = app(ContentSettings::class);
    expect($content->about_stats)->toBe('Test stats');
    expect($content->about_badges)->toBe(['Badge 1', 'Badge 2']);
    expect($content->testimonials)->toHaveCount(1);
});

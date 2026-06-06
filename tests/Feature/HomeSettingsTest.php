<?php

use App\Models\Product;
use App\Settings\HeroSettings;
use Illuminate\Support\Facades\Storage;

it('renders home with hero url from product', function () {
    $product = Product::factory()->create();
    $tmpFile = tempnam(sys_get_temp_dir(), 'model_');
    rename($tmpFile, $tmpFile.'.glb');
    $tmpFile .= '.glb';
    file_put_contents($tmpFile, "glTF\x02\x00\x00\x00");
    $product->addMedia($tmpFile)
        ->usingFileName('model.glb')
        ->toMediaCollection('model_3d');
    @unlink($tmpFile);

    $hero = app(HeroSettings::class);
    $hero->source = 'product';
    $hero->product_id = $product->id;
    $hero->save();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->has('heroUrl')
    );
});

it('renders home with hero url from upload', function () {
    Storage::fake('public');
    Storage::disk('public')->put('hero/test.glb', 'test');

    $hero = app(HeroSettings::class);
    $hero->source = 'upload';
    $hero->media_path = 'hero/test.glb';
    $hero->save();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->has('heroUrl')
    );
});

it('renders home without hero url when no source', function () {
    $hero = app(HeroSettings::class);
    $hero->source = 'product';
    $hero->product_id = null;
    $hero->save();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->where('heroUrl', null)
    );
});

<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HeroSettings extends Settings
{
    public string $source;

    public ?int $product_id;

    public ?string $media_path;

    public static function group(): string
    {
        return 'hero';
    }
}

<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ContentSettings extends Settings
{
    public array $testimonials;

    public string $about_stats;

    public array $about_badges;

    public static function group(): string
    {
        return 'content';
    }
}

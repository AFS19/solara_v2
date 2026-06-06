<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $blueprint): void {
            $blueprint->add('site_name', 'Sunscreen Store');
        });

        $this->migrator->inGroup('hero', function (SettingsBlueprint $blueprint): void {
            $blueprint->add('source', 'product');
            $blueprint->add('product_id', null);
            $blueprint->add('media_path', null);
        });

        $this->migrator->inGroup('contact', function (SettingsBlueprint $blueprint): void {
            $blueprint->add('email', 'contact@example.com');
            $blueprint->add('phone', null);
            $blueprint->add('address', '123 Sunscreen Ave, Sun City');
        });

        $this->migrator->inGroup('social', function (SettingsBlueprint $blueprint): void {
            $blueprint->add('whatsapp', null);
            $blueprint->add('facebook', null);
            $blueprint->add('instagram', null);
            $blueprint->add('tiktok', null);
        });
    }
};

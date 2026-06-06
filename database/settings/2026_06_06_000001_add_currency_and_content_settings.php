<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('general', function (SettingsBlueprint $blueprint): void {
            $blueprint->add('currency', 'MAD');
        });

        $this->migrator->inGroup('content', function (SettingsBlueprint $blueprint): void {
            $blueprint->add('testimonials', [
                ['name' => 'Sophie M.', 'loc' => 'Paris', 'product' => 'SPF 50+ Visage', 'rating' => 5, 'text' => "Ma peau n'a jamais été aussi bien protégée. Texture légère et non grasse, je recommande !"],
                ['name' => 'Karim B.', 'loc' => 'Casablanca', 'product' => 'SPF 30 Corps', 'rating' => 5, 'text' => 'Parfait pour le sport. Tient très bien à la transpiration et ne pique pas les yeux.'],
                ['name' => 'Léa T.', 'loc' => 'Lyon', 'product' => 'SPF 50+ Enfants', 'rating' => 5, 'text' => "Mes enfants adorent l'odeur ! Et moi j'adore qu'elle soit 100% naturelle."],
                ['name' => 'Yasmine A.', 'loc' => 'Marrakech', 'product' => 'SPF 50 Stick', 'rating' => 4, 'text' => 'Très pratique en voyage. Le stick est compact et efficace.'],
                ['name' => 'Marc D.', 'loc' => 'Bordeaux', 'product' => 'SPF 30 Corps', 'rating' => 5, 'text' => "Utilisé tout l'été en surf, résistant à l'eau, impeccable."],
                ['name' => 'Nadia R.', 'loc' => 'Toulouse', 'product' => 'SPF 50+ Visage', 'rating' => 5, 'text' => "Fini les taches de vieillesse. Je l'utilise toute l'année maintenant."],
            ]);
            $blueprint->add('about_stats', 'Fondée en 2019 · 50 000+ clients · 100% naturel');
            $blueprint->add('about_badges', ['🌿 Vegan', '🧪 Sans parabènes', '♻️ Éco-responsable']);
        });
    }
};

<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'slug' => 'mentions-legales',
            'title' => 'Mentions légales',
            'content' => <<<'HTML'
<h2>1. Éditeur du site</h2>
<p>Le site Solara est édité par [Nom de la société], immatriculée au registre du commerce de [Ville], sous le numéro [Numéro].</p>

<h2>2. Hébergement</h2>
<p>Le site est hébergé par [Nom de l'hébergeur], dont le siège social est situé [Adresse].</p>

<h2>3. Propriété intellectuelle</h2>
<p>L'ensemble du contenu de ce site (textes, images, vidéos, logos) est protégé par le droit d'auteur. Toute reproduction, même partielle, est interdite sans autorisation préalable.</p>

<h2>4. Données personnelles</h2>
<p>Les données collectées sur ce site sont traitées conformément au Règlement Général sur la Protection des Données (RGPD). Pour toute demande, contactez-nous via notre formulaire.</p>

<h2>5. Contact</h2>
<p>Email : contact@solara.ma</p>
<p>Téléphone : +212 5XX-XXXXXX</p>
HTML,
            'is_active' => true,
        ]);
    }
}

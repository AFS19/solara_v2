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
<p>Le site <strong>solara.ma</strong> est édité par <strong>SOLARA SARL</strong>, société à responsabilité limitée immatriculée au Registre de Commerce de Casablanca sous le numéro [RCCM].</p>
<ul>
<li><strong>Identifiant Fiscal (IF)</strong> : [IF]</li>
<li><strong>ICE</strong> : [ICE]</li>
<li><strong>Capital social</strong> : [MONTANT] DHS</li>
<li><strong>Siège social</strong> : [ADRESSE COMPLÈTE], Casablanca, Maroc</li>
<li><strong>Représentant légal</strong> : [NOM DU GÉRANT]</li>
</ul>

<h2>2. Hébergement</h2>
<p>Le site est hébergé par <strong>[NOM HÉBERGEUR]</strong>, dont le siège social est situé à [ADRESSE HÉBERGEUR].</p>
<ul>
<li><strong>Téléphone</strong> : [TÉLÉPHONE HÉBERGEUR]</li>
<li><strong>Site web</strong> : [URL HÉBERGEUR]</li>
</ul>

<h2>3. Propriété intellectuelle</h2>
<p>L'ensemble du contenu du site solara.ma (textes, images, vidéos, logos, marques, design, base de données) est protégé par le droit d'auteur et le droit des marques.</p>
<p>La marque <strong>Solara</strong>, le logo, les slogans et l'ensemble des signes distinctifs sont la propriété exclusive de SOLARA SARL. Toute reproduction, représentation, modification ou exploitation, totale ou partielle, sans autorisation préalable écrite est strictement interdite et constitue une contrefaçon sanctionnée par les articles 363 et suivants du Code de la propriété intellectuelle marocain.</p>

<h2>4. Conditions d'utilisation</h2>
<p>L'utilisation du site solara.ma implique l'acceptation pleine et entière des présentes mentions légales. SOLARA SARL se réserve le droit de modifier à tout moment le contenu du site.</p>
<p>Les informations fournies sur ce site le sont à titre indicatif. SOLARA SARL s'efforce d'assurer l'exactitude et la mise à jour des informations, mais ne saurait être tenue pour responsable d'omissions, d'inexactitudes ou de carences dans la mise à jour.</p>

<h2>5. Données personnelles</h2>
<p>Conformément à la <strong>Loi 09-08</strong> relative à la protection des données personnelles au Maroc et au <strong>Règlement Général sur la Protection des Données (RGPD)</strong> pour les résidents de l'Union Européenne, SOLARA SARL s'engage à protéger la vie privée de ses utilisateurs.</p>
<p>Les données collectées (nom, email, adresse, téléphone) sont nécessaires au traitement des commandes, à la livraison des produits et à l'amélioration de nos services. Elles ne sont jamais vendues à des tiers.</p>
<p><strong>Vos droits :</strong> Vous disposez d'un droit d'accès, de rectification, d'opposition et de suppression de vos données personnelles. Pour exercer ces droits, contactez-nous à <a href="mailto:privacy@solara.ma">privacy@solara.ma</a> ou par courrier à notre siège social.</p>

<h2>6. Cookies</h2>
<p>Le site solara.ma utilise des cookies pour améliorer votre expérience de navigation, analyser le trafic et personnaliser le contenu. En poursuivant votre navigation, vous acceptez l'utilisation de ces cookies. Vous pouvez à tout moment modifier vos préférences via les paramètres de votre navigateur.</p>

<h2>7. Paiement sécurisé</h2>
<p>Les paiements sur solara.ma sont sécurisés par des protocoles de cryptage SSL. SOLARA SARL ne stocke pas les numéros de cartes bancaires. Les transactions sont traitées par nos partenaires de paiement certifiés PCI DSS.</p>

<h2>8. Livraisons et retours</h2>
<p><strong>Livraison :</strong> Nous livrons partout au Maroc en 3 à 5 jours ouvrés, ainsi qu'en France et en Europe.</p>
<p><strong>Retours :</strong> Vous disposez de 30 jours à réception de votre commande pour retourner un produit. La politique « Satisfait ou remboursé » s'applique sans condition sur les produits non ouverts et dans leur emballage d'origine.</p>

<h2>9. Contact</h2>
<p>Pour toute question relative aux présentes mentions légales ou à l'utilisation du site :</p>
<ul>
<li><strong>Email</strong> : <a href="mailto:contact@solara.ma">contact@solara.ma</a></li>
<li><strong>Téléphone</strong> : +212 5XX-XXXXXX</li>
<li><strong>Formulaire</strong> : <a href="/contact">Page de contact</a></li>
</ul>

<h2>10. Droit applicable et litiges</h2>
<p>Les présentes mentions légales sont soumises au droit marocain. En cas de litige, les parties s'engagent à rechercher une solution amiable avant toute action judiciaire. À défaut, les tribunaux compétents seront ceux du ressort de Casablanca.</p>

<h2>11. Crédits</h2>
<ul>
<li><strong>Conception et développement</strong> : <a href="http://github.com/AFS19" _blank>Mohamed Afssas</a></li>
<!-- <li><strong>Photographies</strong> : SOLARA SARL et [PHOTOGRAPHE/STOCK] — Tous droits réservés.</li>
<li><strong>Icônes</strong> : Lucide Icons (licence MIT)</li> -->
</ul>

<p class="text-sm text-mutedtone mt-8">Dernière mise à jour : juin 2026</p>
HTML,
            'is_active' => true,
        ]);
    }
}

import { Instagram, Facebook, Music2, MessageCircle } from "lucide-react";
import { usePage } from '@inertiajs/react';
import { t } from "@/lib/i18n";
import type { SiteSettings } from '@/types';

const socialIcons: Record<string, typeof Instagram> = {
  instagram: Instagram,
  facebook: Facebook,
  tiktok: Music2,
  whatsapp: MessageCircle,
};

export function Footer() {
  const { siteSettings } = usePage<{ siteSettings: SiteSettings }>().props;
  const { general, contact, social } = siteSettings;

  const socialEntries = Object.entries(social)
    .filter(([, value]) => value)
    .map(([platform, value]) => ({
      platform,
      url: platform === 'whatsapp' ? `https://wa.me/${value}` : (value as string),
      Icon: socialIcons[platform] || Instagram,
    }));

  return (
    <footer className="bg-charcoal text-cream/90">
      <div className="max-w-[1280px] mx-auto px-6 py-16 grid grid-cols-2 md:grid-cols-4 gap-10">
        <div className="col-span-2 md:col-span-1">
          <div className="font-display text-2xl text-gold">{general.site_name}</div>
          <p className="mt-4 text-sm text-cream/70 max-w-xs">{t("footer.tagline")}</p>
          <div className="mt-5 flex gap-3">
            {socialEntries.map(({ platform, url, Icon }) => (
              <a
                key={platform}
                href={url}
                target="_blank"
                rel="noopener noreferrer"
                className="w-9 h-9 rounded-full border border-white/15 flex items-center justify-center hover:bg-gold hover:border-gold transition-colors"
              >
                <Icon size={16} />
              </a>
            ))}
          </div>
        </div>

        <div>
          <h4 className="text-white text-sm font-medium mb-4">{t("footer.nav")}</h4>
          <ul className="space-y-2.5 text-sm text-cream/70">
            <li><a href="#hero" className="hover:text-gold">Accueil</a></li>
            <li><a href="#products" className="hover:text-gold">Produits</a></li>
            <li><a href="#spf-guide" className="hover:text-gold">Guide SPF</a></li>
            <li><a href="#about" className="hover:text-gold">À propos</a></li>
            <li><a href="#" className="hover:text-gold">Blog</a></li>
          </ul>
        </div>

        <div>
          <h4 className="text-white text-sm font-medium mb-4">{t("footer.help")}</h4>
          <ul className="space-y-2.5 text-sm text-cream/70">
            <li><a href="#faq" className="hover:text-gold">FAQ</a></li>
            <li><a href="#" className="hover:text-gold">Livraison</a></li>
            <li><a href="#" className="hover:text-gold">Retours</a></li>
            <li><a href="#" className="hover:text-gold">Contact</a></li>
            <li><a href="#" className="hover:text-gold">Mentions légales</a></li>
          </ul>
        </div>

        <div>
          <h4 className="text-white text-sm font-medium mb-4">{t("footer.contact")}</h4>
          <ul className="space-y-2.5 text-sm text-cream/70">
            <li>
              <a href={`mailto:${contact.email}`}> {contact.email} </a>
            </li>
            <li>
              <a href={`tel:${contact.phone}`}> {contact.phone || ''} </a>
            </li>
            <li> {contact.address} </li>
          </ul>
        </div>
      </div>

      <div className="border-t border-white/10">
        <div className="max-w-[1280px] mx-auto px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-3 text-xs text-cream/60">
          <span>© {new Date().getFullYear()} {general.site_name} · Made with ☀️ in Morocco</span>
          <div className="flex gap-2">
            {["M.AFSSAS"].map((p) => (
              <span key={p} className="px-2.5 py-1 rounded bg-white/5 border border-white/10">
                {p}
              </span>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
}

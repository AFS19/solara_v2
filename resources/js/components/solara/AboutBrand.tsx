import { usePage } from '@inertiajs/react';
import { t } from "@/lib/i18n";
import type { SiteSettings } from '@/types';

export function AboutBrand() {
  const { siteSettings } = usePage<{ siteSettings: SiteSettings }>().props;
  const { about_stats, about_badges } = siteSettings.content;

  return (
    <section id="about" className="py-24 bg-white">
      <div className="max-w-[1280px] mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">
        <div className="relative">
          <img
            src="https://placehold.co/560x400/E8D5B0/2C2C2C?text=Solara"
            alt="Solara"
            className="w-full rounded-3xl object-cover"
          />
          <div className="absolute -bottom-6 -right-2 md:right-6 bg-white rounded-2xl p-5 shadow-xl max-w-[260px]">
            <p className="text-sm text-charcoal">
              <span className="text-gold font-medium">{about_stats}</span>
            </p>
          </div>
        </div>

        <div>
          <span className="text-xs uppercase tracking-[0.2em] text-gold font-medium">
            {t("about.label")}
          </span>
          <h2 className="mt-3 text-4xl md:text-5xl text-charcoal">{t("about.title")}</h2>
          <p className="mt-6 text-mutedtone leading-relaxed">{t("about.p1")}</p>
          <p className="mt-4 text-mutedtone leading-relaxed">{t("about.p2")}</p>

          <div className="mt-6 flex flex-wrap gap-2">
            {about_badges.map((v: string) => (
              <span key={v} className="text-sm bg-cream border border-border text-charcoal px-4 py-1.5 rounded-full">
                {v}
              </span>
            ))}
          </div>

          <a href="#" className="mt-8 inline-block text-gold font-medium hover:underline underline-offset-4">
            {t("about.more")}
          </a>
        </div>
      </div>
    </section>
  );
}

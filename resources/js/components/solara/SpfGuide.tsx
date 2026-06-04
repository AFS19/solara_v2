import { t } from "@/lib/i18n";

const cards = [
  {
    spf: "15",
    titleKey: "spf.15.title",
    bullets: ["Activités quotidiennes", "Peaux mates à foncées", "Nuageux ou ombre"],
    tag: "Idéal pour le quotidien",
    highlight: false,
  },
  {
    spf: "30",
    titleKey: "spf.30.title",
    bullets: ["Activités en extérieur", "Tous types de peau", "Recommandé par les dermatologues"],
    tag: "Le plus populaire ⭐",
    highlight: true,
  },
  {
    spf: "50+",
    titleKey: "spf.50.title",
    bullets: ["Exposition prolongée", "Peaux sensibles", "Montagne & plage"],
    tag: "Protection maximale",
    highlight: false,
  },
];

export function SpfGuide() {
  return (
    <section id="spf-guide" className="py-24 bg-white">
      <div className="max-w-[1280px] mx-auto px-6">
        <div className="text-center mb-14">
          <span className="text-xs uppercase tracking-[0.2em] text-gold font-medium">
            {t("spf.label")}
          </span>
          <h2 className="mt-3 text-4xl md:text-5xl text-charcoal">{t("spf.title")}</h2>
          <p className="mt-4 text-mutedtone max-w-xl mx-auto">{t("spf.subtitle")}</p>
        </div>

        <div className="grid md:grid-cols-3 gap-6">
          {cards.map((c) => (
            <div
              key={c.spf}
              className={`relative bg-cream rounded-2xl p-8 transition-all hover:-translate-y-1 ${
                c.highlight ? "border-2 border-gold shadow-lg" : "border border-border"
              }`}
            >
              <div className="font-display text-7xl text-gold leading-none">{c.spf}</div>
              <h3 className="mt-4 text-xl text-charcoal">{t(c.titleKey)}</h3>
              <ul className="mt-5 space-y-2 text-sm text-mutedtone">
                {c.bullets.map((b) => (
                  <li key={b} className="flex gap-2">
                    <span className="text-gold">·</span> {b}
                  </li>
                ))}
              </ul>
              <span className="mt-6 inline-block text-xs bg-white border border-border text-charcoal px-3 py-1.5 rounded-full">
                {c.tag}
              </span>
            </div>
          ))}
        </div>

        <div className="mt-16 max-w-3xl mx-auto">
          <div className="h-3 rounded-full" style={{
            background: "linear-gradient(90deg, #4ade80 0%, #facc15 30%, #fb923c 55%, #ef4444 80%, #7e22ce 100%)"
          }} />
          <div className="mt-2 grid grid-cols-5 text-[11px] text-mutedtone text-center">
            <span>Faible</span>
            <span>Modéré</span>
            <span>Élevé</span>
            <span>Très élevé</span>
            <span>Extrême</span>
          </div>
        </div>

        <div className="text-center mt-12">
          <a href="#" className="text-gold underline-offset-4 hover:underline font-medium">
            {t("spf.cta")}
          </a>
        </div>
      </div>
    </section>
  );
}

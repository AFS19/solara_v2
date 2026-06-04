import { Star } from "lucide-react";
import { t } from "@/lib/i18n";

const data = [
  { name: "Sophie M.", loc: "Paris", product: "SPF 50+ Visage", rating: 5, text: "Ma peau n'a jamais été aussi bien protégée. Texture légère et non grasse, je recommande !" },
  { name: "Karim B.", loc: "Casablanca", product: "SPF 30 Corps", rating: 5, text: "Parfait pour le sport. Tient très bien à la transpiration et ne pique pas les yeux." },
  { name: "Léa T.", loc: "Lyon", product: "SPF 50+ Enfants", rating: 5, text: "Mes enfants adorent l'odeur ! Et moi j'adore qu'elle soit 100% naturelle." },
  { name: "Yasmine A.", loc: "Marrakech", product: "SPF 50 Stick", rating: 4, text: "Très pratique en voyage. Le stick est compact et efficace." },
  { name: "Marc D.", loc: "Bordeaux", product: "SPF 30 Corps", rating: 5, text: "Utilisé tout l'été en surf, résistant à l'eau, impeccable." },
  { name: "Nadia R.", loc: "Toulouse", product: "SPF 50+ Visage", rating: 5, text: "Fini les taches de vieillesse. Je l'utilise toute l'année maintenant." },
];

function initials(name: string) {
  return name.split(" ").map((p) => p[0]).join("").toUpperCase();
}

export function Testimonials() {
  return (
    <section id="testimonials" className="py-24 bg-cream">
      <div className="max-w-[1280px] mx-auto px-6">
        <div className="text-center mb-14">
          <h2 className="text-4xl md:text-5xl text-charcoal">{t("testimonials.title")}</h2>
          <div className="mt-4 inline-flex items-center gap-2 text-mutedtone">
            <span className="flex">
              {[1, 2, 3, 4, 5].map((i) => (
                <Star key={i} size={16} className="fill-gold text-gold" />
              ))}
            </span>
            <span>{t("testimonials.summary")}</span>
          </div>
        </div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {data.map((d) => (
            <div key={d.name} className="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
              <div className="flex items-center gap-3">
                <div className="w-11 h-11 rounded-full bg-sand flex items-center justify-center text-charcoal font-medium">
                  {initials(d.name)}
                </div>
                <div>
                  <div className="text-charcoal font-medium text-sm">{d.name}</div>
                  <div className="text-mutedtone text-xs">{d.loc}</div>
                </div>
              </div>
              <div className="mt-4 flex items-center justify-between">
                <span className="text-[11px] bg-cream text-charcoal px-2.5 py-1 rounded-full">
                  {d.product}
                </span>
                <span className="flex">
                  {Array.from({ length: 5 }).map((_, i) => (
                    <Star
                      key={i}
                      size={13}
                      className={i < d.rating ? "fill-gold text-gold" : "text-border"}
                    />
                  ))}
                </span>
              </div>
              <p className="mt-4 italic text-charcoal/80 text-sm leading-relaxed">"{d.text}"</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

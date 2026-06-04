import { useState } from "react";
import { Heart, Star } from "lucide-react";
import { t } from "@/lib/i18n";

type Product = {
  id: string;
  name: string;
  spf: string;
  price: string;
  tag?: string;
  desc: string;
  img: string;
};

const products: Product[] = [
  { id: "p1", name: "Crème Solaire Visage", spf: "SPF 50+", price: "24,90 €", tag: "Bestseller", desc: "Texture fluide, fini invisible", img: "https://placehold.co/600x600/FDF6EC/C9A84C?text=Visage" },
  { id: "p2", name: "Lait Solaire Corps", spf: "SPF 30", price: "19,90 €", desc: "Hydratation longue durée", img: "https://placehold.co/600x600/F5E6C8/2C2C2C?text=Corps" },
  { id: "p3", name: "Stick Solaire", spf: "SPF 50", price: "14,90 €", tag: "Nouveau", desc: "Format nomade, application précise", img: "https://placehold.co/600x600/E8D5B0/2C2C2C?text=Stick" },
  { id: "p4", name: "Brume Solaire", spf: "SPF 15", price: "17,50 €", desc: "Spray rafraîchissant léger", img: "https://placehold.co/600x600/FDF6EC/E8734A?text=Brume" },
  { id: "p5", name: "Gel Solaire Sport", spf: "SPF 50+", price: "22,90 €", tag: "Sport", desc: "Ultra résistant à la transpiration", img: "https://placehold.co/600x600/F5E6C8/2C2C2C?text=Sport" },
  { id: "p6", name: "Crème Enfants", spf: "SPF 50+", price: "21,90 €", tag: "Famille", desc: "Formule douce pour peaux fragiles", img: "https://placehold.co/600x600/FDF6EC/C9A84C?text=Enfants" },
];

const filters = ["Tous", "SPF 15", "SPF 30", "SPF 50", "SPF 50+"];

const tagColor: Record<string, string> = {
  Bestseller: "bg-gold text-white",
  Nouveau: "bg-coral text-white",
  Sport: "bg-blue-500 text-white",
  Famille: "bg-teal-500 text-white",
};

export function ProductsGrid() {
  const [active, setActive] = useState("Tous");

  const visible = active === "Tous" ? products : products.filter((p) => p.spf === active);

  return (
    <section id="products" className="py-24 bg-cream">
      <div className="max-w-[1280px] mx-auto px-6">
        <div className="text-center mb-10">
          <span className="text-xs uppercase tracking-[0.2em] text-gold font-medium">
            {t("products.label")}
          </span>
          <h2 className="mt-3 text-4xl md:text-5xl text-charcoal">{t("products.title")}</h2>
          <p className="mt-4 text-mutedtone max-w-xl mx-auto">{t("products.subtitle")}</p>
        </div>

        <div className="flex flex-wrap justify-center gap-2 mb-12">
          {filters.map((f) => {
            const label = f === "Tous" ? t("products.filter.all") : f;
            const isActive = active === f;
            return (
              <button
                key={f}
                onClick={() => setActive(f)}
                className={`px-5 py-2 rounded-full text-sm transition-all btn-press-active ${
                  isActive
                    ? "bg-gold text-white border border-gold"
                    : "border border-border text-charcoal hover:border-gold"
                }`}
              >
                {label}
              </button>
            );
          })}
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
          {visible.map((p) => (
            <article
              key={p.id}
              data-product-id={p.id}
              data-spf={p.spf}
              className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
            >
              <div className="relative aspect-square bg-cream overflow-hidden">
                <img src={p.img} alt={p.name} className="w-full h-full object-cover" loading="lazy" />
                {p.tag && (
                  <span className={`absolute top-3 left-3 text-[11px] font-medium px-3 py-1 rounded-full ${tagColor[p.tag]}`}>
                    {p.tag}
                  </span>
                )}
                <button
                  aria-label="Wishlist"
                  className="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-charcoal hover:text-coral transition-colors"
                >
                  <Heart size={16} />
                </button>
                <button
                  data-action="open-3d-viewer"
                  data-product-id={p.id}
                  className="absolute bottom-3 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-charcoal text-white text-xs px-4 py-2 rounded-full"
                >
                  {t("products.view3d")} 🔄
                </button>
              </div>

              <div className="p-5">
                <div className="flex items-start justify-between gap-2">
                  <h3 className="font-display text-[18px] text-charcoal">{p.name}</h3>
                  <span className="shrink-0 bg-sand text-charcoal text-[11px] px-2 py-0.5 rounded-full">
                    {p.spf}
                  </span>
                </div>
                <p className="mt-1 text-[13px] text-mutedtone">{p.desc}</p>

                <div className="mt-3 flex items-center justify-between">
                  <span className="text-gold font-semibold text-[20px]">{p.price}</span>
                  <div className="flex items-center gap-1 text-mutedtone text-xs">
                    <Star size={14} className="fill-gold text-gold" />
                    <span>4.5</span>
                    <span>(128)</span>
                  </div>
                </div>

                <button className="mt-4 w-full bg-coral text-white py-2.5 rounded-full text-sm font-medium hover:bg-coral/90 btn-press btn-press-active">
                  {t("products.add")}
                </button>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}

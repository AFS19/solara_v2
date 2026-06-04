import { useState } from "react";
import { Link } from "@inertiajs/react";
import { Heart, Star } from "lucide-react";
import { t } from "@/lib/i18n";

interface ProductFromDb {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  price: string;
  spf: number | null;
  featured: boolean;
  has_3d_model: boolean;
  category: { id: number; name: string; slug: string };
  media: { id: number; collection_name: string; original_url: string }[];
}

const filters = ["Tous", "SPF 15", "SPF 30", "SPF 50", "SPF 50+"];

function productImage(product: ProductFromDb): string {
  const img = product.media.find((m) => m.collection_name === "images");
  return img?.original_url || "https://placehold.co/600x600/FDF6EC/C9A84C?text=Produit";
}

function spfMatches(active: string, spf: number | null): boolean {
  if (active === "Tous") return true;
  if (active === "SPF 50+") return spf !== null && spf >= 50;
  return spf === parseInt(active.replace("SPF ", ""), 10);
}

export function ProductsGrid({ products: dbProducts }: { products?: ProductFromDb[] }) {
  const [active, setActive] = useState("Tous");

  const visible = dbProducts?.filter((p) => spfMatches(active, p.spf)) ?? [];

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

        {visible.length === 0 ? (
          <p className="text-center text-mutedtone py-12">{t("products.empty")}</p>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            {visible.map((p) => (
              <Link
                key={p.id}
                href={`/produits/${p.slug}`}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
              >
                <div className="relative aspect-square bg-cream overflow-hidden">
                  <img
                    src={productImage(p)}
                    alt={p.name}
                    className="w-full h-full object-cover"
                    loading="lazy"
                  />
                  <span className="absolute top-3 left-3 text-[11px] font-medium px-3 py-1 rounded-full bg-gold text-white">
                    Featured
                  </span>
                  <button
                    aria-label="Wishlist"
                    className="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-charcoal hover:text-coral transition-colors"
                    onClick={(e) => e.preventDefault()}
                  >
                    <Heart size={16} />
                  </button>
                </div>

                <div className="p-5">
                  <div className="flex items-start justify-between gap-2">
                    <h3 className="font-display text-[18px] text-charcoal">{p.name}</h3>
                    {p.spf && (
                      <span className="shrink-0 bg-sand text-charcoal text-[11px] px-2 py-0.5 rounded-full">
                        SPF {p.spf}
                      </span>
                    )}
                  </div>
                  <p className="mt-1 text-[13px] text-mutedtone line-clamp-2">{p.description || ""}</p>

                  <div className="mt-3 flex items-center justify-between">
                    <span className="text-gold font-semibold text-[20px]">{p.price} MAD</span>
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
              </Link>
            ))}
          </div>
        )}
      </div>
    </section>
  );
}

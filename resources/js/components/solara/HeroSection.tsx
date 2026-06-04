import { lazy, Suspense, useEffect, useState } from "react";
import { Sun } from "lucide-react";
import { t } from "@/lib/i18n";

const HeroCanvas = lazy(() => import("@/components/HeroCanvas"));

function Fallback() {
  return (
    <div className="absolute inset-8 rounded-3xl bg-sand flex flex-col items-center justify-center text-mutedtone shadow-inner">
      <Sun size={56} className="text-gold mb-3" />
      <span className="text-sm">[Modèle 3D ici]</span>
    </div>
  );
}

interface HeroSectionProps {
  has3dModel?: boolean;
}

export function HeroSection({ has3dModel = true }: HeroSectionProps) {
  const [mounted, setMounted] = useState(false);

  useEffect(() => {
    setMounted(true);
  }, []);

  return (
    <section
      id="hero"
      className="min-h-screen pt-24 pb-16 bg-gradient-to-br from-[#FDF6EC] to-[#F5E6C8]"
    >
      <div className="max-w-[1280px] mx-auto px-6 grid lg:grid-cols-5 gap-12 items-center min-h-[calc(100vh-6rem)]">
        <div className="lg:col-span-3 animate-fade-up">
          <span className="inline-block text-xs uppercase tracking-[0.2em] text-gold font-medium mb-5">
            {t("hero.label")}
          </span>
          <h1 className="font-display text-[clamp(2.5rem,6vw,4.5rem)] leading-[1.05] text-charcoal whitespace-pre-line">
            {t("hero.title")}
          </h1>
          <p className="mt-6 text-lg text-mutedtone max-w-xl leading-relaxed">
            {t("hero.subtitle")}
          </p>

          <div className="mt-8 flex flex-wrap gap-4">
            <a
              href="#products"
              className="inline-flex items-center bg-coral text-white px-8 py-4 rounded-full text-base font-medium shadow-lg shadow-coral/20 btn-press btn-press-active hover:bg-coral/90"
            >
              {t("hero.cta_primary")}
            </a>
            <a
              href="#spf-guide"
              className="inline-flex items-center border-2 border-gold text-gold px-8 py-4 rounded-full text-base font-medium btn-press btn-press-active hover:bg-gold hover:text-white"
            >
              {t("hero.cta_secondary")}
            </a>
          </div>

          <div className="mt-10 flex flex-wrap gap-x-6 gap-y-2 text-sm text-mutedtone">
            {["Vegan", "SPF 15–50+", "Résistant à l'eau", "Dermatologiquement testé"].map((b) => (
              <span key={b} className="inline-flex items-center gap-1.5">
                <span className="text-gold">✓</span> {b}
              </span>
            ))}
          </div>
        </div>

        <div className="lg:col-span-2 flex justify-center">
          <div className="relative w-[min(480px,90vw)] aspect-square">
            <div className="absolute inset-0 rounded-full border-2 border-dashed border-gold/40 animate-rotate-slow" />
            <div className="absolute inset-4 rounded-full border border-coral/20 animate-rotate-slow" style={{ animationDirection: "reverse", animationDuration: "40s" }} />
            {mounted && has3dModel ? (
              <div className="absolute inset-8 rounded-3xl overflow-hidden">
                <Suspense fallback={<Fallback />}>
                  <HeroCanvas />
                </Suspense>
              </div>
            ) : (
              <Fallback />
            )}
          </div>
        </div>
      </div>
    </section>
  );
}

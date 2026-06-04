import { Palette, Hand, RefreshCw } from "lucide-react";
import { t } from "@/lib/i18n";

const steps = [
  { icon: Palette, title: "Choisissez votre SPF", desc: "selon votre phototype et votre activité" },
  { icon: Hand, title: "Appliquez généreusement", desc: "20 minutes avant l'exposition" },
  { icon: RefreshCw, title: "Renouvelez toutes les 2h", desc: "ou après la baignade" },
];

export function HowItWorks() {
  return (
    <section className="py-24 bg-gradient-to-b from-cream to-sand/50">
      <div className="max-w-[1280px] mx-auto px-6">
        <h2 className="text-center text-4xl md:text-5xl text-charcoal mb-16">
          {t("how.title")}
        </h2>
        <div className="relative grid md:grid-cols-3 gap-10">
          <div className="hidden md:block absolute top-10 left-[16%] right-[16%] border-t-2 border-dashed border-gold/40" />
          {steps.map((s, i) => (
            <div key={i} className="relative text-center">
              <div className="relative mx-auto w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center">
                <s.icon size={28} className="text-coral" />
                <span className="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-gold text-white text-sm font-medium flex items-center justify-center">
                  {i + 1}
                </span>
              </div>
              <h3 className="mt-6 text-xl text-charcoal">{s.title}</h3>
              <p className="mt-2 text-mutedtone text-sm">{s.desc}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

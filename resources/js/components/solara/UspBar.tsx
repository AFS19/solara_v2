import { Leaf, Sun, Droplets, FlaskConical } from "lucide-react";
import { t } from "@/lib/i18n";

const items = [
  { icon: Leaf, key: "usp.natural" },
  { icon: Sun, key: "usp.spf" },
  { icon: Droplets, key: "usp.water" },
  { icon: FlaskConical, key: "usp.derm" },
];

export function UspBar() {
  return (
    <section className="bg-charcoal text-cream py-8">
      <div className="max-w-[1280px] mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-y-6 md:divide-x divide-white/10">
        {items.map(({ icon: Icon, key }) => (
          <div key={key} className="flex items-center justify-center gap-3 px-4">
            <Icon size={22} className="text-gold" />
            <span className="text-sm md:text-[15px]">{t(key)}</span>
          </div>
        ))}
      </div>
    </section>
  );
}

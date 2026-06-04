import { useState } from "react";
import { ChevronDown } from "lucide-react";
import { t } from "@/lib/i18n";

const items = [
  { q: "faq.q1", a: "faq.a1" },
  { q: "faq.q2", a: "faq.a2" },
  { q: "faq.q3", a: "faq.a3" },
  { q: "faq.q4", a: "faq.a4" },
  { q: "faq.q5", a: "faq.a5" },
  { q: "faq.q6", a: "faq.a6" },
];

export function FaqSection() {
  const [open, setOpen] = useState<number | null>(0);

  return (
    <section id="faq" className="py-24 bg-cream">
      <div className="max-w-3xl mx-auto px-6">
        <h2 className="text-center text-4xl md:text-5xl text-charcoal mb-12">
          {t("faq.title")}
        </h2>
        <div className="space-y-3">
          {items.map((it, i) => {
            const isOpen = open === i;
            return (
              <div key={i} className="bg-white rounded-xl border border-border overflow-hidden">
                <button
                  onClick={() => setOpen(isOpen ? null : i)}
                  className="w-full flex items-center justify-between text-left p-5"
                >
                  <span className="text-charcoal font-medium">{t(it.q)}</span>
                  <ChevronDown
                    size={20}
                    className={`text-gold transition-transform ${isOpen ? "rotate-180" : ""}`}
                  />
                </button>
                <div
                  className="grid transition-all duration-300 ease-in-out"
                  style={{ gridTemplateRows: isOpen ? "1fr" : "0fr" }}
                >
                  <div className="overflow-hidden">
                    <p className="px-5 pb-5 text-mutedtone text-sm leading-relaxed">
                      {t(it.a)}
                    </p>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}

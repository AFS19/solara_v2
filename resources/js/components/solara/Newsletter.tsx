import { useState, FormEvent } from "react";
import { t } from "@/lib/i18n";

export function Newsletter() {
  const [email, setEmail] = useState("");
  const [sent, setSent] = useState(false);

  const submit = (e: FormEvent) => {
    e.preventDefault();
    if (!email) return;
    setSent(true);
  };

  return (
    <section
      id="newsletter"
      className="py-24"
      style={{ background: "linear-gradient(135deg, #E8734A 0%, #C9A84C 100%)" }}
    >
      <div className="max-w-3xl mx-auto px-6 text-center text-white">
        <h2 className="text-4xl md:text-5xl">{t("newsletter.title")}</h2>
        <p className="mt-4 text-white/90 max-w-xl mx-auto">{t("newsletter.subtitle")}</p>

        {sent ? (
          <p className="mt-8 text-lg font-medium animate-fade-up">{t("newsletter.success")}</p>
        ) : (
          <form
            onSubmit={submit}
            className="mt-8 flex flex-col sm:flex-row gap-3 max-w-xl mx-auto"
          >
            <input
              type="email"
              required
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder={t("newsletter.placeholder")}
              className="flex-1 bg-white text-charcoal placeholder:text-mutedtone px-6 py-4 rounded-full outline-none focus:ring-2 focus:ring-white/50"
            />
            <button
              type="submit"
              className="bg-charcoal text-white px-8 py-4 rounded-full font-medium btn-press btn-press-active hover:bg-charcoal/90"
            >
              {t("newsletter.cta")}
            </button>
          </form>
        )}

        <p className="mt-5 text-xs text-white/80">{t("newsletter.legal")}</p>
      </div>
    </section>
  );
}

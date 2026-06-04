import { useForm } from "@inertiajs/react";
import { subscribe } from "@/routes/newsletter";
import { t } from "@/lib/i18n";

export function Newsletter() {
  const { data, setData, post, processing, errors, recentlySuccessful } =
    useForm({
      email: "",
    });

  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    post(subscribe.url(), {
      preserveScroll: true,
    });
  };

  return (
    <section
      id="newsletter"
      className="py-24"
      style={{ background: "linear-gradient(135deg, #E8734A 0%, #C9A84C 100%)" }}
    >
      <div className="max-w-3xl mx-auto px-6 text-center text-white">
        <h2 className="text-4xl md:text-5xl">{t("newsletter.title")}</h2>
        <p className="mt-4 text-white/90 max-w-xl mx-auto">
          {t("newsletter.subtitle")}
        </p>

        {recentlySuccessful ? (
          <p className="mt-8 text-lg font-medium animate-fade-up">
            {t("newsletter.success")}
          </p>
        ) : (
          <form
            onSubmit={submit}
            className="mt-8 flex flex-col sm:flex-row gap-3 max-w-xl mx-auto"
          >
            <div className="flex-1">
              <input
                type="email"
                required
                value={data.email}
                onChange={(e) => setData("email", e.target.value)}
                placeholder={t("newsletter.placeholder")}
                className="w-full bg-white text-charcoal placeholder:text-mutedtone px-6 py-4 rounded-full outline-none focus:ring-2 focus:ring-white/50"
              />
              {errors.email && (
                <p className="mt-2 text-sm text-white">{errors.email}</p>
              )}
            </div>
            <button
              type="submit"
              disabled={processing}
              className="bg-charcoal text-white px-8 py-4 rounded-full font-medium btn-press btn-press-active hover:bg-charcoal/90 disabled:opacity-50"
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

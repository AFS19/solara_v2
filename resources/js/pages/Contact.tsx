import { Head, useForm } from '@inertiajs/react';
import { t } from '@/lib/i18n';
import { store as contactStore } from '@/routes/contact';

export default function Contact() {
  const { data, setData, post, processing, errors, reset } = useForm({
    full_name: '',
    email: '',
    message: '',
  });

  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    post(contactStore.url(), {
      preserveScroll: true,
      onSuccess: () => reset(),
    });
  };

  return (
    <main className="pt-[64px]">
      <Head title={t('page.contact.title')} />
      <section className="py-16 bg-white min-h-[60vh]">
        <div className="max-w-[640px] mx-auto px-6">
          <h1 className="text-3xl md:text-4xl text-charcoal mb-2">{t('page.contact.title')}</h1>
          <p className="text-mutedtone mb-8">{t('page.contact.subtitle')}</p>

          <form onSubmit={submit} className="space-y-4">
            <div>
              <label className="block text-sm text-charcoal mb-1">{t('contact.form.name')}</label>
              <input
                type="text"
                value={data.full_name}
                onChange={(e) => setData('full_name', e.target.value)}
                className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
              />
              {errors.full_name && <p className="text-coral text-xs mt-1">{errors.full_name}</p>}
            </div>

            <div>
              <label className="block text-sm text-charcoal mb-1">{t('contact.form.email')}</label>
              <input
                type="email"
                value={data.email}
                onChange={(e) => setData('email', e.target.value)}
                className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
              />
              {errors.email && <p className="text-coral text-xs mt-1">{errors.email}</p>}
            </div>

            <div>
              <label className="block text-sm text-charcoal mb-1">{t('contact.form.message')}</label>
              <textarea
                value={data.message}
                onChange={(e) => setData('message', e.target.value)}
                rows={5}
                className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
              />
              {errors.message && <p className="text-coral text-xs mt-1">{errors.message}</p>}
            </div>

            <button
              type="submit"
              disabled={processing}
              className="bg-coral text-white px-8 py-3 rounded-full text-sm font-medium hover:bg-coral/90 disabled:opacity-50"
            >
              {t('contact.form.submit')}
            </button>
          </form>
        </div>
      </section>
    </main>
  );
}

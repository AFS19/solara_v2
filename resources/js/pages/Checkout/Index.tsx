import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { t } from '@/lib/i18n';

interface CartProduct {
  id: number;
  name: string;
  slug: string;
  price: string;
}

interface CartItem {
  product: CartProduct;
  quantity: number;
  subtotal: number;
}

interface PageProps {
  items: CartItem[];
  subtotal: number;
  count: number;
  [key: string]: unknown;
}

export default function CheckoutIndex() {
  const { items, subtotal } = usePage<PageProps>().props;

  const { data, setData, post, processing, errors } = useForm({
    email: '',
    first_name: '',
    last_name: '',
    address: '',
    city: '',
    postal_code: '',
    phone: '',
    payment_method: 'cod',
  });

  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    post('/commande');
  };

  return (
    <main className="pt-[64px]">
      <Head title={t('checkout.title')} />
      <section className="py-16 bg-white min-h-[60vh]">
        <div className="max-w-[1280px] mx-auto px-6">
          <h1 className="text-3xl md:text-4xl text-charcoal mb-8">{t('checkout.title')}</h1>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <form onSubmit={submit} className="lg:col-span-2 space-y-4">
              <div className="bg-cream rounded-2xl p-6 border border-border space-y-4">
                <h3 className="font-semibold text-charcoal">{t('checkout.email')}</h3>
                <input
                  type="email"
                  value={data.email}
                  onChange={(e) => setData('email', e.target.value)}
                  className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                  placeholder={t('checkout.email')}
                />
                {errors.email && <p className="text-coral text-xs">{errors.email}</p>}

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <input
                      type="text"
                      value={data.first_name}
                      onChange={(e) => setData('first_name', e.target.value)}
                      className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                      placeholder={t('checkout.first_name')}
                    />
                    {errors.first_name && <p className="text-coral text-xs">{errors.first_name}</p>}
                  </div>
                  <div>
                    <input
                      type="text"
                      value={data.last_name}
                      onChange={(e) => setData('last_name', e.target.value)}
                      className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                      placeholder={t('checkout.last_name')}
                    />
                    {errors.last_name && <p className="text-coral text-xs">{errors.last_name}</p>}
                  </div>
                </div>

                <input
                  type="text"
                  value={data.address}
                  onChange={(e) => setData('address', e.target.value)}
                  className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                  placeholder={t('checkout.address')}
                />
                {errors.address && <p className="text-coral text-xs">{errors.address}</p>}

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <input
                      type="text"
                      value={data.city}
                      onChange={(e) => setData('city', e.target.value)}
                      className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                      placeholder={t('checkout.city')}
                    />
                    {errors.city && <p className="text-coral text-xs">{errors.city}</p>}
                  </div>
                  <div>
                    <input
                      type="text"
                      value={data.postal_code}
                      onChange={(e) => setData('postal_code', e.target.value)}
                      className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                      placeholder={t('checkout.postal_code')}
                    />
                    {errors.postal_code && <p className="text-coral text-xs">{errors.postal_code}</p>}
                  </div>
                </div>

                <input
                  type="text"
                  value={data.phone}
                  onChange={(e) => setData('phone', e.target.value)}
                  className="w-full rounded-xl border border-border bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                  placeholder={t('checkout.phone')}
                />
                {errors.phone && <p className="text-coral text-xs">{errors.phone}</p>}

                <div className="pt-2">
                  <label className="text-sm text-charcoal">{t('checkout.payment_method')}</label>
                  <input type="hidden" value={data.payment_method} />
                  <div className="mt-1 w-full rounded-xl border border-border bg-cream px-4 py-2 text-sm text-mutedtone">
                    {t('checkout.cod')}
                  </div>
                  <p className="mt-1 text-xs text-mutedtone">{t('checkout.cod_helper')}</p>
                </div>
              </div>

              <button
                type="submit"
                disabled={processing}
                className="w-full bg-coral text-white py-3 rounded-full text-sm font-medium hover:bg-coral/90 disabled:opacity-50"
              >
                {t('checkout.place_order')}
              </button>
            </form>

            <aside className="bg-cream rounded-2xl p-6 border border-border h-fit">
              <h3 className="text-lg font-semibold text-charcoal mb-4">{t('checkout.summary')}</h3>
              <div className="space-y-3">
                {items.map((item) => (
                  <div key={item.product.id} className="flex justify-between text-sm text-charcoal">
                    <span>
                      {item.product.name} x{item.quantity}
                    </span>
                    <span>{item.subtotal.toFixed(2)} MAD</span>
                  </div>
                ))}
              </div>
              <div className="flex justify-between text-charcoal font-semibold text-lg mt-4 pt-4 border-t border-border">
                <span>{t('cart.total')}</span>
                <span>{subtotal.toFixed(2)} MAD</span>
              </div>
            </aside>
          </div>
        </div>
      </section>
    </main>
  );
}

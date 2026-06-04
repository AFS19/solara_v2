import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { t } from '@/lib/i18n';
import { Trash2 } from 'lucide-react';

interface CartProduct {
  id: number;
  name: string;
  slug: string;
  price: string;
  media: { id: number; collection_name: string; original_url: string }[];
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

export default function CartIndex() {
  const { items, subtotal, count } = usePage<PageProps>().props;

  const updateQty = (product: CartProduct, quantity: number) => {
    router.patch(`/panier/${product.slug}`, { quantity }, { preserveState: true, preserveScroll: true });
  };

  const removeItem = (product: CartProduct) => {
    router.delete(`/panier/${product.slug}`, { preserveState: true, preserveScroll: true });
  };

  return (
    <main className="pt-[64px]">
      <Head title={t('cart.title')} />
      <section className="py-16 bg-white min-h-[60vh]">
        <div className="max-w-[1280px] mx-auto px-6">
          <h1 className="text-3xl md:text-4xl text-charcoal mb-8">{t('cart.title')}</h1>

          {items.length === 0 ? (
            <div className="text-center py-20">
              <p className="text-mutedtone text-lg mb-6">{t('cart.empty')}</p>
              <Link
                href="/produits"
                className="inline-block bg-gold text-white px-6 py-3 rounded-full text-sm font-medium hover:bg-gold/90"
              >
                {t('cart.continue_shopping')}
              </Link>
            </div>
          ) : (
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
              <div className="lg:col-span-2 space-y-4">
                {items.map((item) => (
                  <div
                    key={item.product.id}
                    className="flex gap-4 bg-cream rounded-2xl p-4 border border-border"
                  >
                    <img
                      src={
                        item.product.media?.find((m) => m.collection_name === 'images')?.original_url ||
                        'https://placehold.co/120x120/FDF6EC/C9A84C?text=Produit'
                      }
                      alt={item.product.name}
                      className="w-24 h-24 object-cover rounded-xl"
                    />
                    <div className="flex-1">
                      <h3 className="font-display text-charcoal">{item.product.name}</h3>
                      <p className="text-sm text-mutedtone mt-1">
                        {Number(item.product.price).toFixed(2)} MAD
                      </p>
                      <div className="flex items-center gap-3 mt-3">
                        <input
                          type="number"
                          min={0}
                          value={item.quantity}
                          onChange={(e) => updateQty(item.product, Number(e.target.value))}
                          className="w-16 rounded-xl border border-border bg-white px-2 py-1 text-sm text-center focus:outline-none focus:ring-2 focus:ring-gold"
                        />
                        <button
                          onClick={() => removeItem(item.product)}
                          className="text-coral hover:text-coral/80"
                          title={t('cart.remove')}
                        >
                          <Trash2 size={16} />
                        </button>
                      </div>
                    </div>
                    <div className="text-right self-center">
                      <p className="font-semibold text-charcoal">{item.subtotal.toFixed(2)} MAD</p>
                    </div>
                  </div>
                ))}
              </div>

              <aside className="bg-cream rounded-2xl p-6 border border-border h-fit">
                <h3 className="text-lg font-semibold text-charcoal mb-4">{t('cart.total')}</h3>
                <div className="flex justify-between text-charcoal mb-2">
                  <span>{t('cart.subtotal')}</span>
                  <span>{subtotal.toFixed(2)} MAD</span>
                </div>
                <div className="flex justify-between text-charcoal font-semibold text-lg mt-4 pt-4 border-t border-border">
                  <span>{t('cart.total')}</span>
                  <span>{subtotal.toFixed(2)} MAD</span>
                </div>
                <Link
                  href="/commande"
                  className="mt-6 block w-full bg-coral text-white text-center py-3 rounded-full text-sm font-medium hover:bg-coral/90"
                >
                  {t('cart.checkout')}
                </Link>
                <Link
                  href="/produits"
                  className="mt-3 block w-full text-center text-sm text-mutedtone hover:text-charcoal"
                >
                  {t('cart.continue_shopping')}
                </Link>
              </aside>
            </div>
          )}
        </div>
      </section>
    </main>
  );
}

import { Head, Link, usePage } from '@inertiajs/react';
import { t } from '@/lib/i18n';

interface OrderItem {
  id: number;
  name: string;
  price: string;
  quantity: number;
  subtotal: string;
}

interface Order {
  id: number;
  email: string;
  first_name: string;
  last_name: string;
  address: string;
  city: string;
  postal_code: string;
  phone: string | null;
  status: string;
  payment_method: string;
  total: string;
  items: OrderItem[];
}

interface PageProps {
  order: Order;
  [key: string]: unknown;
}

export default function CheckoutSuccess() {
  const { order } = usePage<PageProps>().props;

  return (
    <main className="pt-[64px]">
      <Head title={t('checkout.success_title')} />
      <section className="py-16 bg-white min-h-[60vh]">
        <div className="max-w-[640px] mx-auto px-6 text-center">
          <div className="w-16 h-16 mx-auto mb-6 rounded-full bg-gold/10 flex items-center justify-center text-gold">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>

          <h1 className="text-3xl md:text-4xl text-charcoal">{t('checkout.success_title')}</h1>
          <p className="mt-4 text-mutedtone">{t('checkout.success_message')}</p>

          <div className="mt-8 bg-cream rounded-2xl p-6 border border-border text-left">
            <p className="text-sm text-mutedtone">{t('checkout.order_number').replace(':order', String(order.id))}</p>
            <p className="text-sm text-mutedtone mt-1">
              {order.first_name} {order.last_name} — {order.email}
            </p>
            <p className="text-sm text-mutedtone mt-1">
              {order.address}, {order.postal_code} {order.city}
            </p>

            <div className="mt-4 pt-4 border-t border-border space-y-2">
              {order.items.map((item) => (
                <div key={item.id} className="flex justify-between text-sm text-charcoal">
                  <span>{item.name} x{item.quantity}</span>
                  <span>{Number(item.subtotal).toFixed(2)} MAD</span>
                </div>
              ))}
            </div>

            <div className="mt-4 pt-4 border-t border-border flex justify-between text-charcoal font-semibold">
              <span>{t('cart.total')}</span>
              <span>{Number(order.total).toFixed(2)} MAD</span>
            </div>
          </div>

          <Link
            href="/"
            className="mt-8 inline-block bg-gold text-white px-6 py-3 rounded-full text-sm font-medium hover:bg-gold/90"
          >
            {t('checkout.back_to_home')}
          </Link>
        </div>
      </section>
    </main>
  );
}

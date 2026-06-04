import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { t } from '@/lib/i18n';
import { Heart, Star, ChevronLeft, ChevronRight } from 'lucide-react';

interface Category {
  id: number;
  name: string;
  slug: string;
}

interface Product {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  price: string;
  spf: number | null;
  featured: boolean;
  has_3d_model: boolean;
  category: Category;
  media: { id: number; collection_name: string; original_url: string }[];
}

interface Paginator<T> {
  data: T[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  links: { url: string | null; label: string; active: boolean }[];
  next_page_url: string | null;
  prev_page_url: string | null;
}

interface Filters {
  search: string;
  category: number | null;
  spf: number | null;
  min_price: string | null;
  max_price: string | null;
  featured: boolean;
  sort: string;
}

interface PageProps {
  products: Paginator<Product>;
  categories: Category[];
  spfOptions: (number | null)[];
  filters: Filters;
  [key: string]: unknown;
}

export default function ProductsIndex() {
  const { products, categories, spfOptions, filters } = usePage<PageProps>().props;

  const updateFilter = (key: string, value: string | number | boolean | null) => {
    const params = new URLSearchParams(window.location.search);
    if (value === null || value === '' || value === false) {
      params.delete(key);
    } else {
      params.set(key, String(value));
    }
    params.set('page', '1');
    router.get(`/produits?${params.toString()}`, {}, { preserveState: true, preserveScroll: true });
  };

  const productImage = (product: Product) => {
    const img = product.media.find((m) => m.collection_name === 'images');
    return img?.original_url || 'https://placehold.co/600x600/FDF6EC/C9A84C?text=Produit';
  };

  return (
    <main className="pt-[64px]">
      <Head title={t('title')} />
      <section className="py-16 bg-white">
        <div className="max-w-[1280px] mx-auto px-6">
          <div className="text-center mb-10">
            <h1 className="text-4xl md:text-5xl text-charcoal">{t('title')}</h1>
            <p className="mt-4 text-mutedtone max-w-xl mx-auto">{t('subtitle')}</p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside className="lg:col-span-1 space-y-6">
              <div className="bg-cream rounded-2xl p-5 border border-border">
                <h3 className="text-sm font-semibold text-charcoal mb-4">{t('filter.title')}</h3>

                <div className="space-y-4">
                  <div>
                    <label className="text-xs text-mutedtone block mb-1.5">{t('filter.category')}</label>
                    <select
                      value={filters.category ?? ''}
                      onChange={(e) => updateFilter('category', e.target.value ? Number(e.target.value) : null)}
                      className="w-full rounded-xl border border-border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                    >
                      <option value="">{t('filter.all_categories')}</option>
                      {categories.map((c) => (
                        <option key={c.id} value={c.id}>
                          {c.name}
                        </option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label className="text-xs text-mutedtone block mb-1.5">{t('filter.spf')}</label>
                    <select
                      value={filters.spf ?? ''}
                      onChange={(e) => updateFilter('spf', e.target.value ? Number(e.target.value) : null)}
                      className="w-full rounded-xl border border-border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                    >
                      <option value="">{t('filter.all_spf')}</option>
                      {spfOptions.map((s) => (
                        <option key={s} value={s ?? ''}>
                          SPF {s}
                        </option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label className="text-xs text-mutedtone block mb-1.5">{t('filter.price')}</label>
                    <div className="flex gap-2">
                      <input
                        type="number"
                        placeholder={t('filter.min_price')}
                        value={filters.min_price ?? ''}
                        onChange={(e) => updateFilter('min_price', e.target.value || null)}
                        className="w-1/2 rounded-xl border border-border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                      />
                      <input
                        type="number"
                        placeholder={t('filter.max_price')}
                        value={filters.max_price ?? ''}
                        onChange={(e) => updateFilter('max_price', e.target.value || null)}
                        className="w-1/2 rounded-xl border border-border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                      />
                    </div>
                  </div>

                  <div className="flex items-center gap-2">
                    <input
                      id="featured"
                      type="checkbox"
                      checked={filters.featured}
                      onChange={(e) => updateFilter('featured', e.target.checked)}
                      className="rounded border-border text-gold focus:ring-gold"
                    />
                    <label htmlFor="featured" className="text-sm text-charcoal">
                      {t('filter.featured')}
                    </label>
                  </div>
                </div>

                <button
                  onClick={() => router.get('/produits', {}, { preserveState: true, preserveScroll: true })}
                  className="mt-5 w-full text-xs text-coral hover:text-coral/80 transition-colors"
                >
                  {t('filter.reset')}
                </button>
              </div>

              <div className="bg-cream rounded-2xl p-5 border border-border">
                <label className="text-xs text-mutedtone block mb-1.5">{t('sort.title')}</label>
                <select
                  value={filters.sort}
                  onChange={(e) => updateFilter('sort', e.target.value)}
                  className="w-full rounded-xl border border-border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold"
                >
                  <option value="newest">{t('sort.newest')}</option>
                  <option value="price_asc">{t('sort.price_asc')}</option>
                  <option value="price_desc">{t('sort.price_desc')}</option>
                  <option value="name">{t('sort.name')}</option>
                </select>
              </div>
            </aside>

            <div className="lg:col-span-3">
              <div className="flex items-center justify-between mb-6">
                <p className="text-sm text-mutedtone">
                  {products.total} {products.total === 1 ? t('count_one') : t('count_many')}
                </p>
                <div className="relative">
                  <input
                    type="text"
                    value={filters.search}
                    onChange={(e) => updateFilter('search', e.target.value)}
                    placeholder={t('search')}
                    className="rounded-full border border-border bg-white pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gold w-48 md:w-64"
                  />
                </div>
              </div>

              {products.data.length === 0 && (
                <p className="text-mutedtone text-center py-20">{t('no_results')}</p>
              )}

              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {products.data.map((product) => (
                  <article
                    key={product.id}
                    className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                  >
                    <Link href={`/produits/${product.slug}`} className="block">
                      <div className="relative aspect-square bg-cream overflow-hidden">
                        <img
                          src={productImage(product)}
                          alt={product.name}
                          className="w-full h-full object-cover"
                          loading="lazy"
                        />
                        {product.featured && (
                          <span className="absolute top-3 left-3 text-[11px] font-medium px-3 py-1 rounded-full bg-gold text-white">
                            Featured
                          </span>
                        )}
                        <button
                          aria-label="Wishlist"
                          className="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-charcoal hover:text-coral transition-colors"
                          onClick={(e) => e.preventDefault()}
                        >
                          <Heart size={16} />
                        </button>
                      </div>
                    </Link>

                    <div className="p-5">
                      <Link href={`/produits/${product.slug}`} className="block">
                        <div className="flex items-start justify-between gap-2">
                          <h3 className="font-display text-[18px] text-charcoal">{product.name}</h3>
                          {product.spf && (
                            <span className="shrink-0 bg-sand text-charcoal text-[11px] px-2 py-0.5 rounded-full">
                              SPF {product.spf}
                            </span>
                          )}
                        </div>
                      </Link>
                      <p className="mt-1 text-[13px] text-mutedtone line-clamp-2">{product.description || ''}</p>

                      <div className="mt-3 flex items-center justify-between">
                        <span className="text-gold font-semibold text-[20px]">{product.price} MAD</span>
                        <div className="flex items-center gap-1 text-mutedtone text-xs">
                          <Star size={14} className="fill-gold text-gold" />
                          <span>4.5</span>
                          <span>(128)</span>
                        </div>
                      </div>

                      <button
                        onClick={() => {
                          router.post('/panier/ajouter', { product_id: product.id, quantity: 1 }, {
                            preserveScroll: true,
                            onSuccess: () => toast.success(t('cart.added')),
                          });
                        }}
                        className="mt-4 w-full bg-coral text-white py-2.5 rounded-full text-sm font-medium hover:bg-coral/90 btn-press btn-press-active"
                      >
                        {t('card.add')}
                      </button>
                    </div>
                  </article>
                ))}
              </div>

              {products.last_page > 1 && (
                <div className="flex items-center justify-center gap-2 mt-10">
                  <Link
                    href={products.prev_page_url || ''}
                    preserveState
                    preserveScroll
                    className={`w-9 h-9 rounded-full border border-border flex items-center justify-center text-sm ${
                      products.prev_page_url ? 'hover:bg-cream text-charcoal' : 'text-mutedtone pointer-events-none'
                    }`}
                  >
                    <ChevronLeft size={16} />
                  </Link>

                  {products.links
                    .filter((l) => !l.label.includes('&'))
                    .map((link, i) => (
                      <Link
                        key={i}
                        href={link.url || ''}
                        preserveState
                        preserveScroll
                        className={`w-9 h-9 rounded-full flex items-center justify-center text-sm ${
                          link.active
                            ? 'bg-gold text-white'
                            : 'border border-border hover:bg-cream text-charcoal'
                        } ${link.url ? '' : 'pointer-events-none text-mutedtone'}`}
                      >
                        {link.label}
                      </Link>
                    ))}

                  <Link
                    href={products.next_page_url || ''}
                    preserveState
                    preserveScroll
                    className={`w-9 h-9 rounded-full border border-border flex items-center justify-center text-sm ${
                      products.next_page_url ? 'hover:bg-cream text-charcoal' : 'text-mutedtone pointer-events-none'
                    }`}
                  >
                    <ChevronRight size={16} />
                  </Link>
                </div>
              )}
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}

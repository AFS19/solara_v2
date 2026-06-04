import { Head, Link, router, usePage } from '@inertiajs/react';
import { t } from '@/lib/i18n';
import { Suspense, lazy } from 'react';
import { ArrowLeft } from 'lucide-react';
import { toast } from 'sonner';

const ProductViewer3D = lazy(() => import('@/components/ProductViewer3D'));

interface Category {
  id: number;
  name: string;
  slug: string;
}

interface Media {
  id: number;
  collection_name: string;
  original_url: string;
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
  media: Media[];
}

interface PageProps {
  product: Product;
  priceFormatted: string;
  model3dUrl: string | null;
  firstImageUrl: string;
  [key: string]: unknown;
}

export default function ProductsShow() {
  const { product, priceFormatted, model3dUrl, firstImageUrl } = usePage<PageProps>().props;

  const fallbackImage = firstImageUrl || 'https://placehold.co/600x600/FDF6EC/C9A84C?text=Produit';

  return (
    <main className="pt-[64px]">
      <Head title={product.name} />
      <section className="py-12 bg-white">
        <div className="max-w-[1280px] mx-auto px-6">
          <Link
            href="/produits"
            className="inline-flex items-center gap-2 text-sm text-mutedtone hover:text-charcoal transition-colors mb-8"
          >
            <ArrowLeft size={16} />
            {t('show.back')}
          </Link>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div className="bg-cream rounded-2xl overflow-hidden aspect-square">
              {model3dUrl ? (
                <Suspense
                  fallback={
                    <div className="w-full h-full flex items-center justify-center text-mutedtone">
                      {t('show.no_3d_model')}
                    </div>
                  }
                >
                  <ProductViewer3D url={model3dUrl} className="w-full h-full" />
                </Suspense>
              ) : (
                <img
                  src={fallbackImage}
                  alt={product.name}
                  className="w-full h-full object-cover"
                />
              )}
            </div>

            <div className="flex flex-col justify-center">
              <h1 className="text-3xl md:text-4xl font-display text-charcoal">{product.name}</h1>
              <div className="mt-2 flex items-center gap-3">
                <span className="text-2xl font-semibold text-gold">{priceFormatted}</span>
                {product.spf && (
                  <span className="bg-sand text-charcoal text-xs px-2 py-1 rounded-full">
                    SPF {product.spf}
                  </span>
                )}
              </div>

              <div className="mt-6 space-y-4 text-mutedtone">
                <p>{product.description || ''}</p>
              </div>

              <div className="mt-8 grid grid-cols-2 gap-4 text-sm">
                <div>
                  <span className="text-mutedtone block">{t('show.category_label')}</span>
                  <span className="text-charcoal font-medium">{product.category.name}</span>
                </div>
                {product.spf && (
                  <div>
                    <span className="text-mutedtone block">{t('show.spf_label')}</span>
                    <span className="text-charcoal font-medium">SPF {product.spf}</span>
                  </div>
                )}
              </div>

              <button
                onClick={() => {
                  router.post('/panier/ajouter', { product_id: product.id, quantity: 1 }, {
                    preserveScroll: true,
                    onSuccess: () => toast.success(t('cart.added')),
                  });
                }}
                className="mt-10 w-full bg-coral text-white py-3 rounded-full text-sm font-medium hover:bg-coral/90 btn-press btn-press-active"
              >
                {t('show.add_to_cart')}
              </button>
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}

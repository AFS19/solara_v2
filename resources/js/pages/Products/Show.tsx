import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { t } from '@/lib/i18n';
import { Suspense, lazy } from 'react';
import { ArrowLeft, Star } from 'lucide-react';
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

interface ReviewUser {
  id: number;
  name: string;
}

interface Review {
  id: number;
  name: string;
  email: string;
  rating: number;
  comment: string | null;
  created_at: string;
  user: ReviewUser | null;
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
  reviews: Review[];
  averageRating: number | null;
  reviewsCount: number;
  auth: {
    user: ReviewUser | null;
  };
  [key: string]: unknown;
}

function StarRating({ rating }: { rating: number }) {
  return (
    <div className="flex items-center gap-0.5">
      {[1, 2, 3, 4, 5].map((star) => (
        <Star
          key={star}
          size={16}
          className={
            star <= rating
              ? 'text-gold fill-gold'
              : 'text-gray-300 fill-gray-300'
          }
        />
      ))}
    </div>
  );
}

export default function ProductsShow() {
  const { product, priceFormatted, model3dUrl, firstImageUrl, reviews, averageRating, reviewsCount, auth } =
    usePage<PageProps>().props;

  const fallbackImage = firstImageUrl || 'https://placehold.co/600x600/FDF6EC/C9A84C?text=Produit';

  const { data, setData, post, processing, errors, recentlySuccessful, reset } =
    useForm({
      rating: 5,
      comment: '',
      name: auth.user?.name ?? '',
      email: auth.user?.email ?? '',
    });

  const submitReview = (e: React.FormEvent) => {
    e.preventDefault();
    post(`/produits/${product.slug}/reviews`, {
      preserveScroll: true,
      onSuccess: () => {
        toast.success(t('reviews.success'));
        reset();
      },
    });
  };

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

              {averageRating !== null && (
                <div className="mt-3 flex items-center gap-2">
                  <StarRating rating={Math.round(averageRating)} />
                  <span className="text-sm text-mutedtone">
                    {t('show.reviews_count').replace(':count', String(reviewsCount))}
                  </span>
                </div>
              )}

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

      {/* Reviews */}
      <section className="py-12 bg-cream">
        <div className="max-w-[1280px] mx-auto px-6">
          <h2 className="text-2xl font-display text-charcoal mb-8">
            {t('show.reviews_title')}
          </h2>

          {reviews.length === 0 ? (
            <p className="text-mutedtone">{t('show.no_reviews')}</p>
          ) : (
            <div className="space-y-6">
              {reviews.map((review) => (
                <div key={review.id} className="bg-white rounded-xl p-6">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                      <span className="text-sm font-medium text-charcoal">
                        {review.user?.name ?? review.name}
                      </span>
                      <StarRating rating={review.rating} />
                    </div>
                    <span className="text-xs text-mutedtone">
                      {new Date(review.created_at).toLocaleDateString('fr-FR')}
                    </span>
                  </div>
                  {review.comment && (
                    <p className="mt-3 text-sm text-mutedtone">{review.comment}</p>
                  )}
                </div>
              ))}
            </div>
          )}

          <div className="mt-10 bg-white rounded-xl p-6">
            <h3 className="text-lg font-medium text-charcoal mb-4">
              {t('show.write_review')}
            </h3>

            {recentlySuccessful ? (
              <p className="text-sm text-green-600">{t('reviews.success')}</p>
            ) : (
              <form onSubmit={submitReview} className="space-y-4">
                <div>
                  <label className="block text-sm text-mutedtone mb-1">
                    {t('show.your_rating')}
                  </label>
                  <select
                    value={data.rating}
                    onChange={(e) => setData('rating', Number(e.target.value))}
                    required
                    className="w-full border border-sand rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-gold/50"
                  >
                    {[5, 4, 3, 2, 1].map((n) => (
                      <option key={n} value={n}>
                        {n} / 5
                      </option>
                    ))}
                  </select>
                  {errors.rating && (
                    <p className="mt-1 text-xs text-red-500">{errors.rating}</p>
                  )}
                </div>

                <div>
                  <label className="block text-sm text-mutedtone mb-1">
                    {t('show.your_comment')}
                  </label>
                  <textarea
                    value={data.comment}
                    onChange={(e) => setData('comment', e.target.value)}
                    rows={4}
                    required
                    className="w-full border border-sand rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-gold/50"
                  />
                  {errors.comment && (
                    <p className="mt-1 text-xs text-red-500">{errors.comment}</p>
                  )}
                </div>

                {!auth.user && (
                  <>
                    <div>
                      <label className="block text-sm text-mutedtone mb-1">
                        {t('show.your_name')}
                      </label>
                      <input
                        type="text"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        className="w-full border border-sand rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-gold/50"
                      />
                      {errors.name && (
                        <p className="mt-1 text-xs text-red-500">{errors.name}</p>
                      )}
                    </div>

                    <div>
                      <label className="block text-sm text-mutedtone mb-1">
                        {t('show.your_email')}
                      </label>
                      <input
                        type="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        className="w-full border border-sand rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-gold/50"
                      />
                      {errors.email && (
                        <p className="mt-1 text-xs text-red-500">{errors.email}</p>
                      )}
                    </div>
                  </>
                )}

                <button
                  type="submit"
                  disabled={processing}
                  className="bg-charcoal text-white px-6 py-2 rounded-full text-sm font-medium hover:bg-charcoal/90 disabled:opacity-50"
                >
                  {t('show.submit_review')}
                </button>
              </form>
            )}
          </div>
        </div>
      </section>
    </main>
  );
}

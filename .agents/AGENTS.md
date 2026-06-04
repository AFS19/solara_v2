# AGENTS.md — Solara Sunscreen E-commerce

> Read this file at the start of every session. Follow every instruction here strictly.
> Do NOT skip sections. Do NOT assume context — always verify against this file first.

---

## Project Overview

**Solara** is a premium sunscreen e-commerce platform targeting the Moroccan market.
- Default language: **French**
- Future localization: Arabic (RTL) and English
- All user-facing strings must use `__('key')` (Laravel) or `t('key')` (React/i18next)
- Never hardcode display strings — always use translation helpers

---

## Tech Stack

| Layer | Technology | Version |
|---|---|---|
| Backend | Laravel | v13 |
| Frontend | React (Inertia.js starter kit) | Latest |
| Admin panel | FilamentPHP | v5 |
| CSS | Tailwind CSS | v4 |
| 3D rendering | Three.js + @react-three/fiber + @react-three/drei | Latest |
| Media | Spatie Media Library | Latest |
| Database | MySQL | 8+ |
| Runtime | PHP | 8.4 |
| Package manager | Composer + npm/bun |  |
| OS (dev) | Parrot OS (KDE Plasma) |  |
| Terminal | Ghostty + zsh (z4h) |  |
| Editor | Neovim + PHPStorm |  |

---

## Project Structure

```
solara/
├── app/
│   ├── Filament/
│   │   └── Resources/         # FilamentPHP resources (ProductResource, OrderResource, etc.)
│   ├── Http/
│   │   ├── Controllers/       # Inertia controllers
│   │   └── Middleware/
│   ├── Models/                # Eloquent models
│   └── Services/              # Business logic (CartService, OrderService, etc.)
├── database/
│   ├── migrations/
│   └── seeders/
├── lang/
│   ├── fr/                    # Default language (French)
│   ├── ar/                    # Arabic (future)
│   └── en/                    # English (future)
├── resources/
│   ├── js/
│   │   ├── components/        # Reusable React components
│   │   │   ├── Header.tsx
│   │   │   ├── Footer.tsx
│   │   │   └── ui/            # Primitive UI components
│   │   ├── pages/             # Inertia page components
│   │   │   ├── Home.tsx       # Landing page (all sections)
│   │   │   ├── Products/
│   │   │   ├── Cart.tsx
│   │   │   └── Checkout.tsx
│   │   ├── hooks/             # Custom React hooks
│   │   ├── lib/               # Utilities (helpers, constants)
│   │   └── types/             # TypeScript interfaces
│   └── views/
│       └── app.blade.php
├── routes/
│   └── web.php
├── storage/
│   └── app/public/
│       ├── models/            # .glb 3D model files
│       └── products/          # Product images
└── AGENTS.md
```

---

## Database Models

### Core models

```
Product
  - id, name (translatable), slug, description (translatable)
  - spf (enum: 15|30|50|50+)
  - price (decimal 8,2), compare_price (decimal 8,2, nullable)
  - stock (int), is_featured (bool), is_active (bool)
  - category_id (FK), has_3d_model (bool)
  - timestamps

Category
  - id, name (translatable), slug, sort_order
  - timestamps

Order
  - id, user_id (FK, nullable for guest), status
  - status enum: pending|paid|processing|shipped|delivered|cancelled
  - subtotal, shipping, total (decimal 8,2)
  - shipping_address (json), billing_address (json)
  - timestamps

OrderItem
  - id, order_id (FK), product_id (FK)
  - quantity (int), unit_price (decimal 8,2)
  - timestamps

NewsletterSubscriber
  - id, email (unique), locale (default: fr), confirmed_at (nullable)
  - timestamps

Review
  - id, product_id (FK), user_id (FK, nullable)
  - rating (tinyint 1-5), content (text), author_name
  - is_approved (bool), timestamps
```

### Media conventions (Spatie Media Library)

- Product images → collection: `images`
- Product 3D model → collection: `model_3d` (single .glb file)
- All media registered in `Product::registerMediaCollections()`

---

## Routing Conventions

```php
// routes/web.php

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/guide-spf', [PageController::class, 'spfGuide'])->name('spf-guide');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');

// Cart & Checkout
Route::post('/panier/ajouter', [CartController::class, 'add'])->name('cart.add');
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::get('/commande', [CheckoutController::class, 'index'])->name('checkout');

// Newsletter
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
```

---

## Inertia.js Conventions

- Controllers return `Inertia::render('PageName', $data)` — never JSON directly
- Page components live in `resources/js/pages/`
- Shared data (auth user, cart count, locale) is passed via `HandleInertiaRequests` middleware
- Use `router.post()` / `router.get()` from `@inertiajs/react` — never `axios` directly
- Form handling: always use `useForm()` from `@inertiajs/react`

---

## React / TypeScript Conventions

- All components are functional with typed props interfaces
- File naming: `PascalCase.tsx` for components, `camelCase.ts` for utilities
- No default exports for utility functions — named exports only
- Components that consume translations import `useTranslation` from `react-i18next`
- 3D components are lazy-loaded: `const HeroCanvas = React.lazy(() => import('@/components/HeroCanvas'))`
- Wrap all Three.js canvas components in `<Suspense fallback={<HeroPlaceholder />}>`

### i18n pattern (React side)

```tsx
import { useTranslation } from 'react-i18next'

export function HeroSection() {
  const { t } = useTranslation()
  return <h1>{t('hero.title')}</h1>
}
```

### Translation key format

```
section.element[.modifier]

Examples:
  hero.title
  hero.cta_primary
  products.filter.all
  spf.15.title
  faq.q1
  footer.tagline
```

---

## FilamentPHP Conventions

- All resources in `app/Filament/Resources/`
- Naming: `ProductResource`, `OrderResource`, `CategoryResource`, `ReviewResource`, `NewsletterSubscriberResource`
- Use `->translateLabel()` on all form fields and table columns
- Admin panel prefix: `/admin`
- Every resource must have: `List`, `Create`, `Edit` pages minimum
- Use `SpatieMediaLibraryFileUpload` for image uploads in forms
- Use `SpatieMediaLibraryImageColumn` for image previews in tables

### ProductResource fields reference

```php
// Form fields
TextInput::make('name')->required()->maxLength(255)
Textarea::make('description')->rows(4)
Select::make('spf')->options(['15'=>'SPF 15','30'=>'SPF 30','50'=>'SPF 50','50+'=>'SPF 50+'])->required()
TextInput::make('price')->numeric()->prefix('€')->required()
TextInput::make('stock')->numeric()->default(0)
Toggle::make('is_featured')
Toggle::make('is_active')->default(true)
SpatieMediaLibraryFileUpload::make('images')->collection('images')->multiple()->reorderable()
SpatieMediaLibraryFileUpload::make('model_3d')->collection('model_3d')->acceptedFileTypes(['model/gltf-binary','.glb'])
```

---

## Localization Rules

### Laravel side (`lang/fr/*.php` or `lang/fr.json`)

- Always use `__('key')` in Blade views and `trans('key')` in PHP
- Namespace by feature: `products.title`, `nav.home`, `footer.tagline`
- Never hardcode French strings outside of `lang/fr/`
- Create keys in `lang/fr/` first — leave `lang/ar/` and `lang/en/` with same keys but empty values (`""`) as placeholders

### Arabic (future)

- When implementing AR: add `dir="rtl"` to `<html>` via a middleware that reads the active locale
- Tailwind RTL: use `rtl:` variant prefix — do NOT duplicate components for RTL

---

## 3D Model Conventions (Three.js)

- Hero canvas: `id="hero-3d-canvas"` in DOM — the `<HeroCanvas>` component mounts here
- Product viewer: triggered by `data-action="open-3d-viewer"` + `data-product-id` attribute
- GLB files served from: `/storage/models/{product_slug}.glb`
- Always use `useGLTF.preload()` for models used in the hero
- OrbitControls enabled on product viewer, disabled on hero (auto-rotate only)
- Fallback: if no `.glb` exists for a product (`has_3d_model = false`), show the product image instead

---

## Commands Reference

```bash
# Development
php artisan serve                          # Laravel dev server
npm run dev                                # Vite dev server (run alongside Laravel)

# Database
php artisan migrate                        # Run migrations
php artisan migrate:fresh --seed           # Fresh DB with seeders
php artisan db:seed --class=ProductSeeder  # Run specific seeder

# Filament
php artisan make:filament-resource Product --generate   # Scaffold resource
php artisan filament:make-user                          # Create admin user

# Storage
php artisan storage:link                   # Link public storage

# Translations
php artisan lang:publish                   # Publish lang files

# Cache
php artisan optimize:clear                 # Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Code Style Rules

- PHP: follow PSR-12, no trailing whitespace, 4-space indent
- TypeScript: 2-space indent, single quotes, no semicolons (Prettier defaults)
- Always run `php artisan test` before marking a task complete
- No `console.log` left in committed React code
- No `dd()` or `dump()` left in committed PHP code
- Use `$model->update([...])` — never `$model->field = value; $model->save()` for bulk updates
- Eager load relationships — never lazy load inside loops (N+1 rule)
- Every new migration must be reversible (`down()` method implemented)

---

## Critical Notes for the Agent

1. **Never hardcode display text** — always use `__()` or `t()`
2. **Check `has_3d_model`** before attempting to load a `.glb` file
3. **All monetary values** stored in decimal(8,2) — display formatted with `number_format($price, 2, ',', ' ') . ' €'`
4. **Images are served via Spatie** — never reference `public/` paths directly; use `$product->getFirstMediaUrl('images')`
5. **Cart is session-based** for guests — stored in `session('cart')` as array; convert to `OrderItem` on checkout
6. **Locale switching** happens via `Route::get('/lang/{locale}', ...)` — stores in session and redirects back
7. **Arabic locale** requires `lang/ar.json` to exist even if empty — otherwise Laravel throws a missing file error
8. **FilamentPHP v5** uses a different syntax from v2/v3 — do not use deprecated `->label()` without `->translateLabel()` context

---

## Current Development Phase

Track progress here — update after completing each phase:

- [ ] Phase 1 — Lovable template integrated into `resources/js/`
- [ ] Phase 2 — Three.js hero canvas wired up with placeholder GLB
- [ ] Phase 3 — FilamentPHP `ProductResource` with media upload
- [ ] Phase 4 — Public product listing page (Inertia data flow)
- [ ] Phase 5 — Product detail page with 3D viewer
- [ ] Phase 6 — Cart (session-based) + Checkout flow
- [ ] Phase 7 — Order management in Filament
- [ ] Phase 8 — Newsletter subscription
- [ ] Phase 9 — Reviews system
- [ ] Phase 10 — i18n AR + RTL support
- [ ] Phase 11 — SEO (sitemap, meta tags, Open Graph)
- [ ] Phase 12 — Payment integration (Stripe / CashPlus)

<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use App\Settings\ContactSettings;
use App\Settings\GeneralSettings;
use App\Settings\HeroSettings;
use App\Settings\SocialSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'locale' => app()->getLocale(),
            'cartCount' => fn () => app(CartService::class)->count(),
            'translations' => fn () => array_merge(
                Arr::dot(trans('home', [], 'fr')),
                Arr::dot(trans('products', [], 'fr')),
                Arr::dot(['cart' => trans('cart', [], 'fr')]),
                Arr::dot(['checkout' => trans('checkout', [], 'fr')]),
                Arr::dot(['reviews' => trans('reviews', [], 'fr')]),
            ),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user,
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'currentTeam' => fn () => $user?->currentTeam ? $user->toUserTeam($user->currentTeam) : null,
            'teams' => fn () => $user?->toUserTeams(includeCurrent: true) ?? [],
            'siteSettings' => [
                'general' => app(GeneralSettings::class),
                'hero' => app(HeroSettings::class),
                'contact' => app(ContactSettings::class),
                'social' => app(SocialSettings::class),
            ],
        ];
    }
}

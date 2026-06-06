<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Settings\HeroSettings;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(HeroSettings $heroSettings)
    {
        $heroUrl = match ($heroSettings->source) {
            'product' => $heroSettings->product_id
                ? Product::query()->find($heroSettings->product_id)?->getFirstMediaUrl('model_3d')
                : null,
            'upload' => $heroSettings->media_path ? Storage::url($heroSettings->media_path) : null,
            default => null,
        };

        return Inertia::render('Home', [
            'featuredProducts' => Product::query()
                ->with(['category', 'media'])
                ->where('featured', true)
                ->latest()
                ->take(6)
                ->get(),
            'heroUrl' => $heroUrl,
        ]);
    }
}

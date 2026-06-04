<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'featuredProducts' => Product::query()
                ->with(['category', 'media'])
                ->where('featured', true)
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}

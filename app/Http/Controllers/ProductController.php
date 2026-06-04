<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['category', 'media'])
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search');
                $query->where(function ($q) use ($search): void {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request): void {
                $query->where('category_id', $request->integer('category'));
            })
            ->when($request->filled('spf'), function ($query) use ($request): void {
                $query->where('spf', $request->integer('spf'));
            })
            ->when($request->filled('min_price'), function ($query) use ($request): void {
                $query->where('price', '>=', $request->input('min_price'));
            })
            ->when($request->filled('max_price'), function ($query) use ($request): void {
                $query->where('price', '<=', $request->input('max_price'));
            })
            ->when($request->boolean('featured'), function ($query): void {
                $query->where('featured', true);
            });

        $sort = (string) $request->string('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => Category::orderBy('sort')->get(['id', 'name', 'slug']),
            'spfOptions' => Product::distinct()->orderBy('spf', 'asc')->pluck('spf'),
            'filters' => [
                'search' => $request->string('search'),
                'category' => $request->integer('category'),
                'spf' => $request->integer('spf'),
                'min_price' => $request->input('min_price'),
                'max_price' => $request->input('max_price'),
                'featured' => $request->boolean('featured'),
                'sort' => $sort,
            ],
        ]);
    }
}

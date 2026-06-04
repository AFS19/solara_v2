<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index(): Response
    {
        return Inertia::render('Cart/Index', [
            'items' => $this->cartService->getContents(),
            'subtotal' => $this->cartService->subtotal(),
            'count' => $this->cartService->count(),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $this->cartService->add($product, $data['quantity'] ?? 1);

        return back()->with('success', __('cart.added'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $this->cartService->updateQuantity($product, $data['quantity']);

        return back()->with('success', __('cart.updated'));
    }

    public function remove(Product $product): RedirectResponse
    {
        $this->cartService->remove($product);

        return back()->with('success', __('cart.removed'));
    }
}

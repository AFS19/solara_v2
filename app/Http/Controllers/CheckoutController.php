<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
    ) {}

    public function index(): Response|RedirectResponse
    {
        $contents = $this->cartService->getContents();

        if (empty($contents)) {
            return redirect()->route('products.index');
        }

        return Inertia::render('Checkout/Index', [
            'items' => $contents,
            'subtotal' => $this->cartService->subtotal(),
            'count' => $this->cartService->count(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $contents = $this->cartService->getContents();

        if (empty($contents)) {
            return redirect()->route('products.index')->with('error', __('checkout.cart_empty'));
        }

        $order = $this->orderService->createFromCart($request->validated());

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): Response
    {
        return Inertia::render('Checkout/Success', [
            'order' => $order->load('items'),
        ]);
    }
}

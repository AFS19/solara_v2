<?php

namespace App\Services;

use App\Models\Product;
use Binafy\LaravelCart\LaravelCart;

class CartService
{
    private function userId(): string
    {
        return auth()->id() ? (string) auth()->id() : session()->getId();
    }

    private function sessionKey(): string
    {
        return 'cart_'.$this->userId();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $userId = $this->userId();
        $cart = session($this->sessionKey(), []);

        $exists = false;
        foreach ($cart as $item) {
            if ($item['itemable_id'] === $product->getKey() && $item['itemable_type'] === Product::class) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            LaravelCart::driver('session')->increaseQuantity($product, $quantity, $userId);
        } else {
            LaravelCart::driver('session')->storeItem([
                'itemable' => $product,
                'quantity' => $quantity,
            ], $userId);
        }
    }

    public function updateQuantity(Product $product, int $quantity): void
    {
        $userId = $this->userId();
        $cart = session($this->sessionKey(), []);

        $current = 0;
        foreach ($cart as $item) {
            if ($item['itemable_id'] === $product->getKey() && $item['itemable_type'] === Product::class) {
                $current = $item['quantity'];
                break;
            }
        }

        if ($quantity <= 0) {
            LaravelCart::driver('session')->removeItem($product, $userId);

            return;
        }

        $diff = $quantity - $current;

        if ($diff > 0) {
            LaravelCart::driver('session')->increaseQuantity($product, $diff, $userId);
        } elseif ($diff < 0) {
            LaravelCart::driver('session')->decreaseQuantity($product, abs($diff), $userId);
        }
    }

    public function remove(Product $product): void
    {
        LaravelCart::driver('session')->removeItem($product, $this->userId());
    }

    public function clear(): void
    {
        LaravelCart::driver('session')->emptyCart($this->userId());
    }

    /**
     * @return array<int, array{product: Product, quantity: int, subtotal: float}>
     */
    public function getContents(): array
    {
        $cart = session($this->sessionKey(), []);

        if (empty($cart)) {
            return [];
        }

        $ids = collect($cart)->pluck('itemable_id')->unique()->values()->all();
        $products = Product::whereIn('id', $ids)->with('media')->get()->keyBy('id');

        $contents = [];
        foreach ($cart as $item) {
            $product = $products[$item['itemable_id']] ?? null;

            if (! $product) {
                continue;
            }

            $contents[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $product->getPrice() * $item['quantity'],
            ];
        }

        return $contents;
    }

    public function subtotal(): float
    {
        $contents = $this->getContents();

        return collect($contents)->sum('subtotal');
    }

    public function count(): int
    {
        $cart = session($this->sessionKey(), []);

        return collect($cart)->sum('quantity');
    }
}

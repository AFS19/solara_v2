<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    public function __construct(private CartService $cartService) {}

    public function createFromCart(array $data): Order
    {
        $contents = $this->cartService->getContents();

        if (empty($contents)) {
            throw new \RuntimeException('Cart is empty');
        }

        $total = $this->cartService->subtotal();

        /** @var Order $order */
        $order = Order::create([
            'user_id' => auth()->id(),
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'phone' => $data['phone'] ?? null,
            'status' => 'pending',
            'payment_method' => $data['payment_method'] ?? 'cod',
            'payment_status' => 'pending',
            'total' => $total,
        ]);

        foreach ($contents as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'name' => $item['product']->name,
                'price' => $item['product']->getPrice(),
                'quantity' => $item['quantity'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        $this->cartService->clear();

        return $order->load('items');
    }
}

<?php

use App\Models\Product;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

function makeCartItem(Product $product, int $quantity): array
{
    return [
        'itemable_id' => $product->id,
        'itemable_type' => Product::class,
        'quantity' => $quantity,
    ];
}

it('adds product to cart', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/panier/ajouter', [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $response->assertRedirect();
});

it('shows cart page with items', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['price' => 50.00]);

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 3)],
    ])->get('/panier');

    $response->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Cart/Index')
            ->has('items', 1)
            ->where('subtotal', 150)
            ->where('count', 3)
        );
});

it('updates cart quantity', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 2)],
    ])->patch("/panier/{$product->slug}", [
        'quantity' => 5,
    ]);

    $response->assertRedirect();

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 5)],
    ])->get('/panier');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->where('count', 5)
    );
});

it('removes product from cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 1)],
    ])->delete("/panier/{$product->slug}");

    $response->assertRedirect();

    $response = $this->actingAs($user)->withSession([])->get('/panier');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->where('count', 0)
        ->has('items', 0)
    );
});

it('shows checkout page with cart items', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['price' => 120.00]);

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 1)],
    ])->get('/commande');

    $response->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Checkout/Index')
            ->has('items', 1)
            ->where('subtotal', 120)
        );
});

it('redirects from checkout when cart is empty', function () {
    $response = $this->get('/commande');

    $response->assertRedirect('/produits');
});

it('creates order on checkout', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['price' => 75.00, 'name' => 'Crème SPF']);

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 2)],
    ])->post('/commande', [
        'email' => 'test@example.com',
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'address' => '123 Rue Solara',
        'city' => 'Casablanca',
        'postal_code' => '20000',
        'phone' => '0612345678',
        'payment_method' => 'cod',
    ]);

    $response->assertRedirect('/commande/merci/1');

    $this->assertDatabaseHas('orders', [
        'email' => 'test@example.com',
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'status' => 'pending',
        'payment_method' => 'cod',
        'total' => 150.00,
    ]);

    $this->assertDatabaseHas('order_items', [
        'product_id' => $product->id,
        'name' => 'Crème SPF',
        'price' => 75.00,
        'quantity' => 2,
        'subtotal' => 150.00,
    ]);

    $response = $this->actingAs($user)->withSession([])->get('/panier');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->where('count', 0)
        ->has('items', 0)
    );
});

it('fails checkout with invalid data', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 1)],
    ])->post('/commande', [
        'email' => 'not-an-email',
        'first_name' => '',
        'last_name' => '',
        'address' => '',
        'city' => '',
        'postal_code' => '',
        'payment_method' => 'cod',
    ]);

    $response->assertSessionHasErrors(['email', 'first_name', 'last_name', 'address', 'city', 'postal_code', 'phone']);
});

it('fails checkout with invalid phone format', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->withSession([
        "cart_{$user->id}" => [makeCartItem($product, 1)],
    ])->post('/commande', [
        'email' => 'test@example.com',
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'address' => '123 Rue Solara',
        'city' => 'Casablanca',
        'postal_code' => '20000',
        'phone' => '0512345678',
        'payment_method' => 'cod',
    ]);

    $response->assertSessionHasErrors(['phone']);
});

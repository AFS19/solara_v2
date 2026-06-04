<?php

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

it('submits a review as guest', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('reviews.store', $product), [
        'rating' => 4,
        'comment' => 'Super produit !',
        'name' => 'Jean Dupont',
        'email' => 'jean@example.com',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', trans('reviews.success'));

    $this->assertDatabaseHas(Review::class, [
        'product_id' => $product->id,
        'rating' => 4,
        'comment' => 'Super produit !',
        'name' => 'Jean Dupont',
        'email' => 'jean@example.com',
        'is_approved' => false,
    ]);
});

it('submits a review as authenticated user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->post(route('reviews.store', $product), [
        'rating' => 5,
        'comment' => 'Excellent !',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas(Review::class, [
        'product_id' => $product->id,
        'user_id' => $user->id,
        'rating' => 5,
        'name' => $user->name,
        'email' => $user->email,
        'is_approved' => false,
    ]);
});

it('requires rating', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('reviews.store', $product), [
        'comment' => 'Pas de note',
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasErrors(['rating']);
});

it('rejects invalid rating', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('reviews.store', $product), [
        'rating' => 10,
        'comment' => 'Test comment',
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasErrors(['rating']);
});

it('requires name and email for guests', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('reviews.store', $product), [
        'rating' => 3,
        'comment' => 'Test comment',
    ]);

    $response->assertSessionHasErrors(['name', 'email']);
});

it('requires comment', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('reviews.store', $product), [
        'rating' => 3,
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasErrors(['comment']);
});

it('shows only approved reviews on product page', function () {
    $product = Product::factory()->create();
    Review::factory()->approved()->create(['product_id' => $product->id, 'rating' => 5]);
    Review::factory()->create(['product_id' => $product->id, 'rating' => 2]);

    $response = $this->get("/produits/{$product->slug}");

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Products/Show')
        ->has('reviews', 1)
        ->where('reviews.0.rating', 5)
        ->where('averageRating', 5)
        ->where('reviewsCount', 1)
    );
});

it('computes average rating correctly', function () {
    $product = Product::factory()->create();
    Review::factory()->approved()->create(['product_id' => $product->id, 'rating' => 4]);
    Review::factory()->approved()->create(['product_id' => $product->id, 'rating' => 2]);

    $response = $this->get("/produits/{$product->slug}");

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->where('averageRating', 3)
        ->where('reviewsCount', 2)
    );
});

it('returns null average when no approved reviews', function () {
    $product = Product::factory()->create();
    Review::factory()->create(['product_id' => $product->id, 'rating' => 5]);

    $response = $this->get("/produits/{$product->slug}");

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('reviews', 0)
        ->where('averageRating', null)
        ->where('reviewsCount', 0)
    );
});

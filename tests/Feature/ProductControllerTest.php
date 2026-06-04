<?php

use App\Models\Category;
use App\Models\Product;
use Inertia\Testing\AssertableInertia;

it('lists products on /produits', function () {
    $category = Category::factory()->create();
    Product::factory()->count(3)->create(['category_id' => $category->id]);

    $response = $this->get('/produits');

    $response->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Products/Index')
            ->has('products.data', 3)
            ->has('categories')
            ->has('spfOptions')
            ->has('filters')
        );
});

it('filters products by category', function () {
    $categoryA = Category::factory()->create();
    $categoryB = Category::factory()->create();
    $productA = Product::factory()->create(['category_id' => $categoryA->id]);
    Product::factory()->create(['category_id' => $categoryB->id]);

    $response = $this->get("/produits?category={$categoryA->id}");

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('products.data', 1)
        ->where('products.data.0.id', $productA->id)
    );
});

it('filters products by spf', function () {
    $spf30 = Product::factory()->create(['spf' => 30]);
    Product::factory()->create(['spf' => 50]);

    $response = $this->get('/produits?spf=30');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('products.data', 1)
        ->where('products.data.0.id', $spf30->id)
    );
});

it('filters products by price range', function () {
    $cheap = Product::factory()->create(['price' => 10.00]);
    Product::factory()->create(['price' => 100.00]);

    $response = $this->get('/produits?min_price=5&max_price=50');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('products.data', 1)
        ->where('products.data.0.id', $cheap->id)
    );
});

it('filters featured products', function () {
    $featured = Product::factory()->create(['featured' => true]);
    Product::factory()->create(['featured' => false]);

    $response = $this->get('/produits?featured=1');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('products.data', 1)
        ->where('products.data.0.id', $featured->id)
    );
});

it('sorts products by price ascending', function () {
    $category = Category::factory()->create();
    $cheap = Product::factory()->create(['category_id' => $category->id, 'price' => 10.00]);
    $expensive = Product::factory()->create(['category_id' => $category->id, 'price' => 100.00]);

    $response = $this->get('/produits?sort=price_asc');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->where('products.data.0.id', $cheap->id)
        ->where('products.data.1.id', $expensive->id)
    );
});

it('sorts products by price descending', function () {
    $category = Category::factory()->create();
    $cheap = Product::factory()->create(['category_id' => $category->id, 'price' => 10.00]);
    $expensive = Product::factory()->create(['category_id' => $category->id, 'price' => 100.00]);

    $response = $this->get('/produits?sort=price_desc');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->where('products.data.0.id', $expensive->id)
        ->where('products.data.1.id', $cheap->id)
    );
});

it('searches products by name', function () {
    $product = Product::factory()->create(['name' => 'Super Crème']);
    Product::factory()->create(['name' => 'Autre chose']);

    $response = $this->get('/produits?search=Super');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('products.data', 1)
        ->where('products.data.0.id', $product->id)
    );
});

it('returns empty when no products match filters', function () {
    Product::factory()->create(['name' => 'Crème']);

    $response = $this->get('/produits?search=Brume');

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('products.data', 0)
    );
});

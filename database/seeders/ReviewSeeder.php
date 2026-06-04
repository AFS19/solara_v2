<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        foreach ($products as $product) {
            Review::factory()
                ->count(rand(2, 6))
                ->approved()
                ->create(['product_id' => $product->id]);

            Review::factory()
                ->count(rand(0, 3))
                ->create(['product_id' => $product->id]);
        }
    }
}

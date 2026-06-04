<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (! User::where('email', 'admin@solara.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@solara.com',
            ]);
        }

        Category::factory(5)
            ->has(Product::factory()->count(4))
            ->create();

        $this->call([
            ReviewSeeder::class,
        ]);
    }
}

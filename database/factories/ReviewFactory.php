<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $moroccanNames = [
            'Youssef', 'Amina', 'Omar', 'Fatima', 'Hassan', 'Sara', 'Mehdi', 'Laila',
            'Karim', 'Nadia', 'Ahmed', 'Imane', 'Reda', 'Samira', 'Adil', 'Khadija',
            'Soufiane', 'Nawal', 'Badr', 'Hind', 'Anas', 'Meryem', 'Hamza', 'Rachida',
        ];

        return [
            'product_id' => Product::factory(),
            'user_id' => null,
            'name' => $this->faker->randomElement($moroccanNames),
            'email' => $this->faker->safeEmail(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
            'is_approved' => false,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }
}

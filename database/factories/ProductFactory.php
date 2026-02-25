<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 500),
            'sale_price' => fake()->optional(0.3)->randomFloat(2, 5, 300),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'stock' => fake()->numberBetween(0, 100),
            'image' => null,
            'gallery' => null,
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->words(2, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 999),
            'description' => fake()->sentence(),
            'content' => fake()->paragraphs(2, true),
            'price' => fake()->optional(0.7)->randomFloat(2, 50, 500),
            'icon' => 'bi-star',
            'image' => null,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

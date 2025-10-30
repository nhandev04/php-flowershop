<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $flowerTypes = [
            'Rose', 'Sunflower', 'Tulip', 'Orchid', 'Lily', 'Daisy',
            'Carnation', 'Chrysanthemum', 'Peony', 'Hydrangea',
            'Gerbera', 'Iris', 'Lavender', 'Marigold', 'Jasmine'
        ];

        $arrangements = [
            'Bouquet', 'Arrangement', 'Collection', 'Bundle', 'Symphony',
            'Elegance', 'Delight', 'Charm', 'Magic', 'Surprise'
        ];

        $occasions = [
            'Wedding', 'Birthday', 'Valentine', 'Anniversary', 'Sympathy',
            'Get Well', 'New Baby', 'Congratulations', 'Thank You', 'Graduation',
            'Mother\'s Day', 'Spring', 'Summer', 'Autumn', 'Winter'
        ];

        // Generate random flower product name
        $namePattern = fake()->randomElement([
            fake()->randomElement($flowerTypes) . ' ' . fake()->randomElement($arrangements),
            fake()->randomElement($occasions) . ' ' . fake()->randomElement($flowerTypes),
            fake()->randomElement($flowerTypes) . ' ' . fake()->randomElement($occasions) . ' ' . fake()->randomElement($arrangements),
            'Mixed ' . fake()->randomElement($flowerTypes) . ' ' . fake()->randomElement($arrangements),
        ]);

        return [
            'name' => $namePattern,
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'price' => fake()->randomFloat(2, 20, 200),
            'description' => fake()->paragraphs(3, true),
            'image' => 'products/product-' . fake()->numberBetween(1, 20) . '.jpg',
            'stock' => fake()->numberBetween(5, 100),
            'is_active' => fake()->boolean(90),
            'is_featured' => fake()->boolean(20),
        ];
    }
}

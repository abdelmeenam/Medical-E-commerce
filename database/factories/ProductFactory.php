<?php

namespace Database\Factories;

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
        $imageLinks = [
            'https://m.media-amazon.com/images/I/61P7VRznw3L._AC_UF400,400_QL80_.jpg',
            'https://bazaar.express/public/uploads/all/2023-06-08-648148e102bb1.png',
            'https://static.thcdn.com/images/large/original//productimg/1600/1600/12771530-3164918929282606.jpg',
            'https://www.oceanblueomega.com/cdn/shop/files/PDP_Oval_2100.jpg?v=1736896311',
        ];

        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'image' => $this->faker->randomElement($imageLinks),
            'category_id' => Category::factory(),
            'stock' => $this->faker->numberBetween(0, 10),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}

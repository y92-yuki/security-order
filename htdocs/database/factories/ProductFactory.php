<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name'    => $this->faker->word(),
            'manufacturer_id' => mt_rand(1, 10),
            'category_id'     => mt_rand(1, 5),
            'price'           => random_int(150, 100000),
            'is_selling'      => $this->faker->boolean(),
            'memo'            => $this->faker->realText(500),
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];
    }
}

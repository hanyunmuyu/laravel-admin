<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'product_name' => $this->faker->company,
            'brand_id' => $this->faker->numberBetween(1, 20),
            'description' => $this->faker->paragraph(3, true),
            'model' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'quantity' => $this->faker->numberBetween(0, 10000),
            'img' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}

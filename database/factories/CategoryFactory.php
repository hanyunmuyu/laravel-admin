<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'category_name' => $this->faker->name(),
            'description' => $this->faker->words(3, true),
            'parent_id' => $this->faker->numberBetween(0, 2),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}

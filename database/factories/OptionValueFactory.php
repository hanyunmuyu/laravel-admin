<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OptionValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $optionList = Option::all();
        return [
            //
            'option_id' => $this->faker->randomElement($optionList->pluck('id')),
            'name' => $this->faker->name(),

        ];
    }
}

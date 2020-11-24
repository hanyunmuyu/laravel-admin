<?php

namespace Database\Factories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Voucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'code' => $this->faker->shuffleString(join('', range('a', 'z'))),
            'status' => $this->faker->randomElement([0, 1, 2, 3]),
            'price' => $this->faker->randomFloat(2, 1, 200),
            'min_total_money' => $this->faker->randomFloat(2, 1, 1000),
            'start_time' => $this->faker->date(),
            'end_time' => $this->faker->date(),
        ];
    }
}

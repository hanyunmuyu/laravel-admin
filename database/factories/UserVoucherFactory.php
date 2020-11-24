<?php

namespace Database\Factories;

use App\Models\UserVoucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserVoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserVoucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id'=>$this->faker->numberBetween(1,100),
            'voucher_id'=>$this->faker->numberBetween(1,50)
        ];
    }
}

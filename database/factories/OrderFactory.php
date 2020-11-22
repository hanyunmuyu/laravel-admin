<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userList = User::select('id')->get();
        return [
            //
            'user_id' => $this->faker->randomElement($userList->pluck('id')),
            'pay_status' => $this->faker->numberBetween(0, 6),
            'order_number' => $this->faker->date('Ymd') . $this->faker->time('His'),
            'trade_price' => $this->faker->randomFloat(2, 0, 1000),
            'original_price' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}

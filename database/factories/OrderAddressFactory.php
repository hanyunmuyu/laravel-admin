<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orderList = Order::select('order_number')->get();
        return [
            //
            'order_number' => $this->faker->randomElement($orderList->pluck('order_number')),
            'name' => $this->faker->name(),
            'mobile' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'note' => $this->faker->word(),
        ];
    }
}

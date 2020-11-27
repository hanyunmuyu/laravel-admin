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
        $orderList = Order::select('id')->get();
        return [
            //
            'order_id' => $this->faker->randomElement($orderList->pluck('id')),
            'name' => $this->faker->name(),
            'mobile' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'note' => $this->faker->word(),
        ];
    }
}

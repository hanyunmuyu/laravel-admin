<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orderList = Order::all();
        return [
            //
            'order_id' => $this->faker->randomElement($orderList->pluck('id')),
            'product_id' => $this->faker->numberBetween(1, 100),
            'name' => $this->faker->name,
            'model' => $this->faker->name,
            'quantity'=>$this->faker->numberBetween(1,10),
            'price'=>$this->faker->randomFloat(2,1,100),
            'total'=>$this->faker->randomFloat(2,1,100),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

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
            'name' => $this->faker->name(),
            'mobile' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->streetAddress,
            'is_default' => $this->faker->randomElement([0, 1]),
        ];
    }
}

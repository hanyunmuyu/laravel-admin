<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserGlasses;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGlassesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserGlasses::class;

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

            'left_eye_degree' => $this->faker->randomFloat(1, 0, 5),
            'left_eye_astigmatism' => $this->faker->numberBetween(0, 1000),
            'left_glasses_degree' => $this->faker->numberBetween(0, 1000),
            'left_glasses_astigmatism' => $this->faker->numberBetween(0, 1000),
            'right_eye_degree' => $this->faker->randomFloat(1, 0, 5),
            'right_eye_astigmatism' => $this->faker->numberBetween(0, 1000),
            'right_glasses_degree' => $this->faker->numberBetween(0, 1000),
            'right_glasses_astigmatism' => $this->faker->numberBetween(0, 1000),

        ];
    }
}

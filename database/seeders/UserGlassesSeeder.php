<?php

namespace Database\Seeders;

use App\Models\UserGlasses;
use Illuminate\Database\Seeder;

class UserGlassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserGlasses::factory()
            ->times(200)
            ->create();
    }
}

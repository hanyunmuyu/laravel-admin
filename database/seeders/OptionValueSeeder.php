<?php

namespace Database\Seeders;

use App\Models\OptionValue;
use Illuminate\Database\Seeder;

class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        OptionValue::factory()
            ->times(100)
            ->create();
    }
}

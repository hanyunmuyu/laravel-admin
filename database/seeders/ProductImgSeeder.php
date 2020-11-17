<?php

namespace Database\Seeders;

use App\Models\ProductImg;
use Illuminate\Database\Seeder;

class ProductImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ProductImg::factory()
            ->times(500)
            ->create();
    }
}

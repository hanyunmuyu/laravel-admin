<?php

namespace Database\Seeders;

use App\Models\UserVoucher;
use Illuminate\Database\Seeder;

class UserVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserVoucher::factory()
            ->times(50)
            ->create();
    }
}

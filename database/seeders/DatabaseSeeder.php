<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            OptionTypeSeeder::class,
            UserSeeder::class,
            UserAddressSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            CategorySeeder::class,
            OptionSeeder::class,
            OptionValueSeeder::class,
            ProductSeeder::class,
            ProductCategorySeeder::class,
            ProductImgSeeder::class,
            OrderSeeder::class,
            OrderAddressSeeder::class,


        ]);
    }
}

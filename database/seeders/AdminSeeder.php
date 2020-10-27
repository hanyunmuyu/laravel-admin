<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminList = [
            [
                'name' => 'admin',
                'password' => Hash::make('123456abc'),
                'role_id' => 1
            ],

            [
                'name' => 'hanyun',
                'password' => Hash::make('123456abc'),
                'role_id' => 2
            ]
        ];
        for ($i = 1; $i < 100; $i++) {
            foreach ($adminList as $admin) {
                $admin['name'] = $admin['name'] . '-' . $i;
                Admin::create($admin);
            }
        }
    }
}

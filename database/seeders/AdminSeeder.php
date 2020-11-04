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
        foreach ($adminList as $admin) {
            $admin['name'] = $admin['name'];
            Admin::create($admin);
        }
    }
}

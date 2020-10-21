<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roleList = [
            [
                'role_name' => '超级管理员',
            ],
            [
                'role_name' => '编辑',
            ],
        ];
        for ($i = 0; $i < 200; $i++) {
            foreach ($roleList as $role) {
                $role['role_name'] = $role['role_name'].$i;
                Role::create($role);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissionList = [
            [
                'api_path' => '/login',
                'title' => '登录',
                'url_path' => '/login',
            ]
        ];
        foreach ($permissionList as $permission) {
            Permissions::create($permission);
        }
    }
}

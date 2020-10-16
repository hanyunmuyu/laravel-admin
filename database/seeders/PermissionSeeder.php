<?php

namespace Database\Seeders;

use App\Models\Permission;
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
                'api_path' => '/admin/login',
                'rule' => '/admin/login',
                'method' => 'post',
                'title' => '登录',
                'url_path' => '/login',
            ],
            [
                'api_path' => '/admin/role/list',
                'rule' => '/admin/role/list',
                'method' => 'get',
                'title' => '角色列表',
                'url_path' => '/role/list',
            ],

        ];
        foreach ($permissionList as $permission) {
            Permission::create($permission);
        }
    }
}

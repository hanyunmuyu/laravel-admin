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
                'api_path' => '',
                'rule' => '',
                'method' => 'get',
                'title' => '首页',
                'path' => '/',
                'parent_id' => 0,
                'is_menu' => 1,
                'children' => []
            ],
            [
                'api_path' => '',
                'rule' => '',
                'method' => 'get',
                'title' => '角色管理',
                'path' => '/',
                'parent_id' => 0,
                'is_menu' => 1,
                'children' => [
                    [
                        'api_path' => '/admin/role/list',
                        'rule' => '/admin/role/list',
                        'method' => 'get',
                        'title' => '角色列表',
                        'path' => '/',
                        'parent_id' => 0,
                        'is_menu' => 1,
                    ]
                ]
            ]

        ];
        foreach ($permissionList as $permission) {
            $children = $permission['children'];
            unset($permission['children']);
            $result = Permission::create($permission);
            if (!$children) {
                continue;
            }
            if ($result) {
                unset($children['children']);
                foreach ($children as $val) {
                    $val['parent_id'] = $result->id;
                    Permission::create($val);
                }
            }
        }
    }
}

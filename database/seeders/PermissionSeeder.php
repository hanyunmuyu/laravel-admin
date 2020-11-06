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
                'title' => '仪表盘',
                'path' => '/admin/dashboard',
                'parent_id' => 0,
                'is_menu' => 1,
                'children' => []
            ],
            [
                'api_path' => '',
                'rule' => '',
                'method' => 'get',
                'title' => '角色管理',
                'path' => '/admin/role',
                'parent_id' => 0,
                'is_menu' => 1,
                'children' => [
                    [
                        'api_path' => '/admin/role/list',
                        'rule' => '/admin/role/list',
                        'method' => 'get',
                        'title' => '角色列表',
                        'path' => '/admin/role/list',
                        'parent_id' => 0,
                        'is_menu' => 1,
                        'children' => [
                            [
                                'api_path' => '/admin/role/list',
                                'rule' => '/admin/role/list',
                                'method' => 'get',
                                'title' => '查看角色列表',
                                'path' => 'roleList',
                                'parent_id' => 0,
                                'is_menu' => 1,
                            ],
                            [
                                'api_path' => '/admin/role/{roleId}',
                                'rule' => '/admin/role/*',
                                'method' => 'delete',
                                'title' => '删除角色',
                                'path' => 'deleteRole',
                                'parent_id' => 0,
                                'is_menu' => 0,
                            ],
                            [
                                'api_path' => '/admin/role/{roleId}',
                                'rule' => '/admin/role/*',
                                'method' => 'post',
                                'title' => '编辑角色',
                                'path' => 'editRole',
                                'parent_id' => 0,
                                'is_menu' => 0,
                            ]
                        ]
                    ],

                ]
            ],
            [
                'api_path' => '',
                'rule' => '',
                'method' => 'get',
                'title' => '管理员管理',
                'path' => '/admin/list',
                'parent_id' => 0,
                'is_menu' => 1,
                'children' => [
                    [
                        'api_path' => '/admin/admin/list',
                        'rule' => '/admin/admin/list',
                        'method' => 'get',
                        'title' => '管理员列表',
                        'path' => '/admin/admin/list',
                        'parent_id' => 0,
                        'is_menu' => 1,
                        'children' => [
                            [
                                'api_path' => '/admin/admin/list',
                                'rule' => '/admin/admin/list',
                                'method' => 'get',
                                'title' => '查看管理员列表',
                                'path' => 'adminList',
                                'parent_id' => 0,
                                'is_menu' => 0,
                            ],
                            [
                                'api_path' => '/admin/{adminId}',
                                'rule' => '/admin/admin/*',
                                'method' => 'post',
                                'title' => '编辑管理员信息',
                                'path' => 'editAdmin',
                                'parent_id' => 0,
                                'is_menu' => 0,
                            ],
                            [
                                'api_path' => '/admin/{adminId}',
                                'rule' => '/admin/admin/*',
                                'method' => 'delete',
                                'title' => '删除管理员',
                                'path' => 'deleteAdmin',
                                'parent_id' => 0,
                                'is_menu' => 0,
                            ]
                        ]
                    ],

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
                    @$children = $val['children'];
                    unset($val['children']);
                    $res = Permission::create($val);
                    if ($children) {
                        foreach ($children as $c) {
                            $c['parent_id'] = $res->id;
                            Permission::create($c);
                        }
                    }
                }
            }
        }
    }
}

<?php

namespace Hanyun\Admin;

use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Permission
{

    /**
     * 如果不需要权限限制就不要加权限判断，加了对超级管理员也要做权限判断，所以权限都要放在权限表里，否则超级管理员也没操作的权限
     * 
     * 如果没有权限就返回false，有权限就返回该权限的具体信息，用于进一步做权限的详细判断
     *
     * @param  Request $request
     * @return boolean|mixed
     */
    public static function check(Request $request)
    {
        $admin = $request->user('admin');

        $pr = new PermissionRepository();
        $permissionList = $pr->getPermissionsByRoleId($admin->role_id);
        foreach ($permissionList as $value) {
            if ($request->is(trim($value['rule'], '/')) && $request->method() === Str::upper($value['method'])) {
                return $value;
            }
        }
        return false;
    }
}

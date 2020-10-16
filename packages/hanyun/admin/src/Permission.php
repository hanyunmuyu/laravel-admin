<?php


namespace Hanyun\Admin;


use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Permission
{
    /**
     * @param Request $request
     * @return false|string[]
     */
    public static function check(Request $request)
    {
        $admin = $request->user('admin');
        if ($admin->role_id === 1) {
            return true;
        }
        $pr = new PermissionRepository();
        $permissionList = $pr->getPermissionsByRoleId($admin->role_id);
        foreach ($permissionList as $value) {
            if ($request->is(trim($value['rule'], '/')) && $request->method() === Str::upper($value['method'])) {
                return true;
            }
        }
        return false;
    }
}

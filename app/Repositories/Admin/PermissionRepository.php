<?php


namespace App\Repositories\Admin;


use App\Models\Permission;

class PermissionRepository
{
    public function getAllPermission()
    {
        return Permission::all();
    }

    public function getPermissionsByRoleId($roleId)
    {
        return Permission::leftjoin('role_permissions', 'permissions.id', '=',
            'role_permissions.permission_id')
            ->where(function ($q) use ($roleId) {
                if ($roleId != 1) {
                    $q->where('role_permissions.role_id', '=', $roleId);
                }
            })
            ->get();
    }
}
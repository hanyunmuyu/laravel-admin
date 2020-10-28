<?php


namespace App\Repositories\Admin;


use App\Models\Role;
use App\Models\RolePermission;

class RoleRepository
{
    public function getRoleList()
    {
        return Role::orderby('id', 'desc')
            ->get();
    }

    public function getRoleByName($roleName)
    {
        return Role::where('role_name', '=', $roleName)
            ->first();
    }

    public function addRole($role)
    {
        return Role::create($role);
    }

    public function updateRole($roleId, $data)
    {
        return Role::where('id', '=', $roleId)->update($data);
    }

    public function deleteRole($roleId)
    {
        return Role::where('id', '=', $roleId)->delete();
    }

    public function getRoleById($roleId)
    {
        return Role::find($roleId);
    }

    public function addRolePermissin($data)
    {
        return RolePermission::insert($data);
    }

    public function deleteRolePermission($roleId)
    {
        return RolePermission::where('role_id', '=', $roleId)->delete();
    }
}

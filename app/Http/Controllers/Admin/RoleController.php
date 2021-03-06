<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\RoleRepository;
use Hanyun\Admin\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private $roleRepository;
    private $permissionRepository;

    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getRoleList()
    {
        $roleList = $this->roleRepository->getRoleList();

        return $this->success($roleList->toArray());
    }

    public function addRole(Request $request)
    {
        $rule = [
            'roleName' => 'required|min:2|max:16',
            'permissionList' => 'required'
        ];
        $msg = [
            'roleName.required' => '角色名称不可以为空',
            'roleName.min' => '角色名称长度不能小于:min位',
            'roleName.max' => '角色名称长度不能大于:max位',
            'roleName.permissionList' => '角色权限不可以为空',
        ];
        $validator = Validator::make(
            $request->all(),
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $roleName = $request->get('roleName');
        $role = $this->roleRepository->getRoleByName($roleName);
        if ($role) {
            return $this->error('角色已经存在');
        }
        $data['role_name'] = $roleName;
        if ($role = $this->roleRepository->addRole($data)) {
            $permissionList = $request->get('permissionList');
            $data = [];
            foreach ($permissionList as $permission) {
                $tmp = [];
                $tmp['role_id'] = $role->id;
                $tmp['permission_id'] = $permission;
                $data[] = $tmp;
            }
            $this->roleRepository->addRolePermissin($data);
            return $this->success();
        }

        return $this->error('创建失败，请稍后重试');
    }

    public function delete(Request $request, $roleId)
    {
        if (!Permission::check($request)) {
            return $this->error('对不起你没有权限');
        }
        $rule = [
            'id' => 'required|integer|min:1',
        ];
        $msg = [
            'id.integer' => 'id必须是数字',
            'id.required' => 'id不可以为空',
            'id.min' => 'id不能小于 :min',
        ];
        $validator = Validator::make(
            ['id' => $roleId],
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        if (intval($roleId) === 1) {
            return $this->error('该角色不可以被删除！');
        }
        if (!Permission::check($request)) {
            return $this->error('你没有删除角色的权限');
        }
        $role = $this->roleRepository->getRoleById($roleId);
        if (!$role) {
            return $this->error('角色不存在');
        }
        if ($this->roleRepository->deleteRole($roleId)) {
            return $this->success();
        }

        return $this->error('删除失败');
    }

    public function updateRole(Request $request, $roleId)
    {
        $rule = [
            'id' => 'required|integer|min:1',
            'roleName' => 'required|min:2|max:16',
        ];
        $msg = [
            'id.integer' => 'id必须是数字',
            'id.required' => 'id不可以为空',
            'id.min' => 'id不能小于 :min',
            'roleName.required' => '角色名称不可以为空',
            'roleName.min' => '角色名称长度不小于:min位',
            'roleName.max' => '角色名称长度不小于:max位',
        ];
        $validator = Validator::make(
            array_merge($request->all(), ['id' => $roleId]),
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $roleName = $request->get('roleName');
        if ($roleName) {
            $admin = $request->user('admin');
            if ($roleId == 1 && $admin->id > 1) {
                return $this->error('对不起！你没有权限修改超级管理员的权限');
            }
            $role = $this->roleRepository->getRoleById($roleId);
            if (!$role) {
                return $this->error('角色不存在');
            }
            $role1 = $this->roleRepository->getRoleByName($roleName);
            if ($role1 && $roleId != $role1->id) {
                return $this->error('角色已经存在');
            }
            $res = $this->roleRepository->updateRole($roleId, ['role_name' => $roleName]);
        }

        $permissionList = $request->get('permissionList');

        if ($permissionList) {
            $permission = [];
            foreach ($permissionList as $value) {
                $tmp = [];
                $tmp['role_id'] = $roleId;
                $tmp['permission_id'] = $value;
                $permission[] = $tmp;
            }
            $this->roleRepository->deleteRolePermission($roleId);
            $this->roleRepository->addRolePermissin($permission);
        }
        if ($res) {
            return $this->success();
        }

        return $this->error();
    }

    public function getRolePermission(Request $request)
    {
    }

    public function getRoleDetail($roleId)
    {
        $rule = [
            'id' => 'required|integer|min:1',

        ];
        $msg = [
            'id.required' => 'id不可以为空',
            'id.min' => 'id不能小于 :min',

        ];
        $validator = Validator::make(
            ['id' => $roleId],
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($validator->errors()->getMessages());
        }
        $role = $this->roleRepository->getRoleById($roleId);
        if (!$role) {
            return $this->error('角色不存在');
        }
        $permissions = $this->permissionRepository->getPermissionsByRoleId($roleId);
        $permissionAll = $this->permissionRepository->getAllPermission();
        $role->permissionList = $permissions->toArray();
        $role->permissionAll = $permissionAll->toArray();
        return $this->success($role->toArray());
    }
}

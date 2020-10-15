<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

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
            'roleName' => 'required|min:6|max|16',
        ];
        $msg = [
            'roleName.required' => ':attribute 不可以为空',
            'roleName.min' => ':attribute 长度不能小于 :min',
            'roleName.max' => ':attribute 不能大于 :max',
        ];
        $validator = Validator::make(
            $request->all(),
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
    }

    public function deleteRole(Request $request)
    {

        $rule = [
            'id' => 'required|integer|min:1',

        ];
        $msg = [
            'id.required' => 'id不可以为空',
            'id.min' => 'id不能小于 :min',
        ];
        $validator = Validator::make(
            $request->all(),
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $roleId = $request->get('id');
        $role = $this->roleRepository->getRoleById($roleId);
        if (!$role) {
            return $this->error('角色不存在');
        }
        if ($this->roleRepository->deleteRole($roleId)) {
            return $this->success();
        }
        return $this->error('删除失败');
    }

    public function updateRole(Request $request)
    {

    }

    public function getRolePermission(Request $request)
    {

    }

    public function getRoleDetail(Request $request)
    {
        $rule = [
            'id' => 'required|integer|min:1',

        ];
        $msg = [
            'id.required' => 'id不可以为空',
            'id.min' => 'id不能小于 :min',

        ];
        $validator = Validator::make(
            $request->all(),
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($validator->errors()->getMessages());
        }
        $roleId = $request->get('id');
        $role = $this->roleRepository->getRoleById($roleId);
        if (!$role) {
            return $this->error('角色不存在');
        }
        $permissions
            = $this->permissionRepository->getPermissionsByRoleId($roleId);
        $role->permissionList = $permissions->toArray();
        return $this->success($role->toArray());
    }
}

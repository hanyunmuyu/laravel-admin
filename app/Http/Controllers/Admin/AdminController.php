<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $adminRepository;
    private $permissionRepository;

    public function __construct(AdminRepository $adminRepository, PermissionRepository $permissionRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        $adminList = $this->adminRepository->getAdminList();
        $adminList->toArray();

        return $this->success();
    }

    public function info(Request $request)
    {
        $admin = $request->user('admin');
        return $this->success($admin->toArray());
    }

    public function getAdminPermission(Request $request)
    {
        $admin = $request->user('admin');
        $permissionList = $this->permissionRepository->getPermissionsByRoleId($admin->role_id);
        return $this->success($permissionList->toArray());
    }

    public function getAdminList(Request $request)
    {
        $adminList = $this->adminRepository->getAdminList();
        return $this->success($adminList->toArray());
    }

    public function deleteAdmin($adminId)
    {
        $rule = [
            'adminId' => 'required|integer|min:1',
        ];
        $msg = [
            'adminId.integer' => 'id必须是数字',
            'adminId.required' => '管理员id不可以为空',
            'adminId.min' => '管理员id不能小于:min位',
        ];
        $validator = Validator::make(
            ['adminId' => $adminId],
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        //强制类型转换  PHP Boolean比较
        if (intval($adminId) === 1) {
            return $this->error('你不能删除超级管理员');
        }
        $admin = $this->adminRepository->getAdminById($adminId);
        if (!$admin) {
            return $this->error('管理员不存在');
        }
        $res = $this->adminRepository->deleteAdmin($adminId);
        if ($res) {
            return $this->success();
        }
        return $this->error('删除错误，请重试！');
    }

    public function updateAdmin(Request $request, $adminId)
    {
        $rule = [
            'id' => 'required|min:1|integer',
            'roleId' => 'required|min:1|integer',
            'name' => 'required|min:2|max:24',
            'password' => 'sometimes|required|min:6|max:24',
        ];
        $msg = [
            'id.required' => '管理员id不可以为空',
            'id.min' => '管理员id不能小于:min位',
            'id.max' => '管理员id不能大于:max位',
            'password.required' => '密码不可以为空',
            'password.min' => '密码长度不能小于:min位',
            'password.max' => '密码长度不能大于:max位',
            'roleId.required' => '角色id不可以为空',
            'roleId.min' => '角色id不能小于:min位',
        ];
        $validator = Validator::make(
            array_merge($request->all(), ['id' => $adminId]),
            $rule,
            $msg
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $admin = $this->adminRepository->getAdminById($adminId);
        if (!$admin) {
            return $this->error('管理员不存在！');
        }
        $admin1 = $this->adminRepository->getAdminByName($request->get('name'));
        if ($admin1 && $admin1->id != $adminId) {
            return $this->error('管理员已经存在');
        }
        $name = $request->get('name');
        $password = $request->get('password');
        if ($password) {
            $data['password'] = Hash::make($password);
        }
        $roleId = $request->get('roleId');
        $data['name'] = $name;
        $data['role_id'] = $roleId;
        $res = $this->adminRepository->updateAdminInfo($adminId, $data);
        if ($res) {
            return $this->success();
        }
        return $this->error('更新失败');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

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
        $permissionList = $this->permissionRepository->getPermissionsByRoleId($admin->role_id);
        $mao['admin'] = $admin->toArray();
        $mao['permissionList'] = $permissionList->toArray();
        return $this->success($mao);
    }
    public function getAdminList(Request $request)
    {
        $adminList = $this->adminRepository->getAdminList();
        return $this->success($adminList->toArray());
    }
    public function deleteAdmin($adminId)
    {
        $rule = [
            'adminId' => 'required|min:1',
        ];
        $msg = [
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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;
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
}

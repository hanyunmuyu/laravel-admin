<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permissionRepository;
    public function __construct(PermissionRepository  $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermission()
    {
        $permissionList = $this->permissionRepository->getAllPermission();
        return $this->success($permissionList->toArray());
    }
}

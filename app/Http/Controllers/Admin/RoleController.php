<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\RoleRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getRoleList()
    {
        $roleList = $this->roleRepository->getRoleList();
        return $this->success($roleList->toArray());
    }

    public function addRole(Request $request)
    {

    }

    public function deleteRole(Request $request)
    {

    }

    public function updateRole(Request $request)
    {

    }
}

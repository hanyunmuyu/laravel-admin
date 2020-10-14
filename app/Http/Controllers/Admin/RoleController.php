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

    /**
     * @OA\Get (
     *     summary="获得角色列表",
     *     path="/admin/role/list",
     *     tags={"admin","role"},
     *     security={{"api_key":{}}},
     *     @OA\Response(
     *          description="
     *     |参数|说明|备注||||
     *     |:---:|:---:|:---:|-----|-----|-----|
     *     |id|id||
     *     |roleName|角色名称|
     *     ",
     *          response="200",
     *      )
     * )
     *
     */
    public function getRoleList()
    {
        $roleList = $this->roleRepository->getRoleList();
        return $this->success($roleList->toArray());
    }

    public function addRole(Request $request)
    {

    }

    /**
     * @OA\Delete(
     *     summary="删除角色",
     *     description="",
     *     path="/admin/role/{roleId}",
     *     tags={"admin","role"},
     *     @OA\Parameter(
     *     name="roleId",
     *     in="path",
     *     @OA\Schema(type="integer"),
     *     required=true,
     *     description="角色id"),
     *     @OA\Response(response=200,description="")
     * )
     */
    public function deleteRole(Request $request)
    {

    }

    public function updateRole(Request $request)
    {

    }
}

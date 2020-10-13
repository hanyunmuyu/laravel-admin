<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class LoginController extends Controller
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @OA\Post (
     *     summary="后台登录",
     *     tags={"admin"},
     *      description="",
     *     path="/admin/login",
     *     security={{"api_key":{}}},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="password",
     *                     description="密码",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     description="用户名",
     *                     type="string"
     *                 ),
     *                  required={"password","name"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="
     *      |参数|说明|备注||||
     *      |:---:|:---:|:---:|-----|-----|-----|
     *      |status|状态|['已取消', '等待付款', '下单成功', '付款中'] 取数组索引||||
     *     ")
     * )
     */
    public function login(Request $request)
    {
        $adminName = $request->get('name');
        $password = $request->get('password');
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'password' => 'required'
            ],
            [
                'name.required' => '用户名不可以为空',
                'password.required' => '密码步而已为空',
            ]
        );
        if ($validator->fails()) {
            return $this->error('error', $validator->errors()->messages());
        }
        $admin = $this->adminRepository->getAdminByName($adminName);;
        if (!$admin) {
            return $this->error('error', ['name' => ['用户不存在']]);
        }

        if (!Hash::check($password, $admin->password)) {
            return $this->error('error', ['password' => ['密码错误']]);

        }
        if (!$token = auth('admin')->login($admin)) {
            return $this->error('认证失败');
        } else {
            return $this->success($this->respondWithToken($token, $admin->toArray()));
        }
    }

    /**
     * @OA\Post (
     *     summary="上传文件",
     *     tags={"admin"},
     *     description="上传文件",
     *     path="/admin/upload",
     *     security={{"api_key":{}}},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(
     *                      property="option",
     *                      default="placed",
     *                      title="Order status",
     *                      description="选项",
     *                      enum={"placed", "approved", "delivered"},
     *                  ),
     *                 @OA\Property(
     *                     description="文件上传",
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                  @OA\Property(
     *                      type="array",
     *                      property="multi",
     *                      description="多选",
     *                      default="available",
     *                      @OA\Items(
     *                          type="string",
     *                          enum = {"available", "pending", "sold"},
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="tags",
     *                      description="手动添加多个",
     *                      type="array",
     *                      @OA\Items(format="datetime",example="2222"),
     *                  ),
     *                  required={"option","file","multi","tags"},
     *                  example={"id": "a3fb6", "name": "Jessica Smith"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             default="available",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"available", "pending", "sold"},
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Tags to filter by",
     *         required=true,
     *         @OA\Schema(
     *           type="array",
     *           @OA\Items(type="string"),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *     response="200",
     *      description="
     *      |参数|说明|备注||||
     *      |:---:|:---:|:---:|-----|-----|-----|
     *      |status|状态|['已取消', '等待付款', '下单成功', '付款中'] 取数组索引||||
     *     ")
     * )
     */
    public function upload()
    {

    }

    protected function respondWithToken(string $token, array $admin)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60,
            'admin' => $admin,
        ];
    }
}

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

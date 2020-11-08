<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $adminName = $request->get('name');
        $password = $request->get('password');
        $rules = [
            'name' => 'required|min:5|max:16',
            'password' => 'required|min:6|max:16',
        ];
        $messages = [
            'name.required' => '用户名不可以为空',
            'name.min' => '用户名长度不可以小于:min位',
            'name.max' => '用户名长度不可以超过:max位',
            'password.required' => '密码不可以为空',
            'password.min' => '密码长度不可以小于:min位',
            'password.max' => '密码长度不可以超过:max位',
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $admin = $this->adminRepository->getAdminByName($adminName);;
        if (!$admin) {
            return $this->error('用户不存在');
        }

        if (!Hash::check($password, $admin->password)) {
            return $this->error('密码错误');
        }
        if (!$token = auth('admin')->login($admin)) {
            return $this->error('认证失败');
        } else {
            return $this->success($this->respondWithToken($token,
                $admin->toArray()));
        }
    }

    public function upload()
    {

    }

    protected function respondWithToken(string $token, array $admin)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60
        ];
    }
}

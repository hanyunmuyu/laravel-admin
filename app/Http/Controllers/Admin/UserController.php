<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserList(Request $request)
    {
        $userList = $this->userRepository->getUserList();
        return $this->success($userList->toArray());
    }

    public function deleteUser(Request $request, $userId)
    {
        $user = $this->userRepository->getUserById($userId);
        if (!$user) {
            return $this->error('用户不存在');
        }
        $res = $this->userRepository->deleteUser($userId);
        if ($res) {
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }
}

<?php


namespace App\Repositories\Admin;


use App\Models\User;

class UserRepository
{
    public function getUserById($userId)
    {
        return User::find($userId);
    }

    public function getUserList($name = null, $mobile = null, $startDate = null, $endDate = null)
    {
        return User::orderby('id', 'desc')
            ->where(function ($q) use ($name) {
                if ($name) {
                    $q->where('name', '=', $name);
                }
            })
            ->where(function ($q) use ($mobile) {
                if ($mobile) {
                    $q->where('mobile', '=', $mobile);
                }
            })
            ->where(function ($q) use ($startDate) {
                if ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                }
            })
            ->where(function ($q) use ($endDate) {
                if ($endDate) {
                    $q->where('created_at', '<=', $endDate . ' 23:59:59');
                }
            })
            ->paginate();
    }

    public function deleteUser($userId)
    {
        return User::where('id', '=', $userId)->delete();
    }
}

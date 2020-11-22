<?php


namespace App\Repositories\Admin;


use App\Models\User;

class UserRepository
{
    public function getUserById($userId)
    {
        return User::find($userId);
    }

    public function getUserList()
    {
        return User::orderby('id', 'desc')
            ->paginate();
    }
    public function deleteUser($userId){
        return User::where('id', '=', $userId)->delete();
    }
}

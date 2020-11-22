<?php


namespace App\Repositories\Admin;


use App\Models\User;

class UserRepository
{
    public function getUserById($userId)
    {
        return User::find($userId);
    }
}

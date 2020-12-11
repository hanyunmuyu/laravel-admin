<?php


namespace App\Repositories\Admin;


use App\Models\UserGlasses;

class UserGlassesRepository
{
    public function getUserGlassesList($userId)
    {
        return UserGlasses::where('user_id', '=', $userId)->get();
    }
}

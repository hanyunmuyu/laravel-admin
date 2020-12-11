<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\UserGlassesRepository;
use Illuminate\Http\Request;

class UserGlassesController extends Controller
{
    //
    private $userGlassesRepository;
    public function __construct(UserGlassesRepository $userGlassesRepository)
    {
        $this->userGlassesRepository = $userGlassesRepository;
    }

    public function getUserGlassesList(Request $request,$userId)
    {
        $res=$this->userGlassesRepository->getUserGlassesList($userId);
        return $this->success($res->toArray());
    }
}

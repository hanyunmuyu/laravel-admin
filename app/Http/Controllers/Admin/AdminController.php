<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AdminController extends Controller
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        $adminList = $this->adminRepository->getAdminList();
        $adminList->toArray();
        return $this->success();
    }
}

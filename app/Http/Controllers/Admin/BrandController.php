<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getBrandList(Request $request)
    {
        $brandList = $this->brandRepository->getBrandList();
        return $this->success($brandList->toArray());
    }

    public function deleteBrand(Request $request, $brandId)
    {
        $brand = $this->brandRepository->getBrandById($brandId);
        if (!$brand) {
            return $this->error('品牌不存在');
        }
        $re = $this->brandRepository->deleteBrand($brandId);
        if ($re) {
            return $this->success('删除成功');
        }
        return $this->error('品牌不存在');
    }
}

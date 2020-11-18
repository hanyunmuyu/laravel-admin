<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ProductCategoryRepository;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    //
    private $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function getCategoryList(Request $request)
    {
        $productCategoryList = $this->productCategoryRepository->getProductCategoryList();
        return $this->success($productCategoryList->toArray());
    }

    public function deleteCategory(Request $request, $categoryId)
    {
        $category = $this->productCategoryRepository->getCategoryById($categoryId);
        if (!$category) {
            return $this->error('分类不存在');
        }
        $res = $this->productCategoryRepository->deleteCategory($categoryId);
        if ($res) {
            return $this->success();
        }
        return $this->error('删除失败！稍后重试！');
    }
}

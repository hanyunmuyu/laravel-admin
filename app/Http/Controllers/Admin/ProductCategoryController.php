<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $keyword = $request->get('keyword');
        $productCategoryList = $this->productCategoryRepository->getProductCategoryList($keyword);
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

    public function addCategory(Request $request)
    {
        $rules = [
            'category_name' => 'required',
            'description' => 'required',
        ];
        $messages = [
            'category_name.required' => '分类名称不可以为空',
            'description.required' => '密码不可以为空',
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $category = $this->productCategoryRepository->getCategoryByName($request->get('category_name'));
        if ($category) {
            return $this->error('分类已经存在');
        }
        $res = $this->productCategoryRepository->addCategory($request->all());
        if ($res) {
            return $this->success();
        }
        return $this->error();
    }
}

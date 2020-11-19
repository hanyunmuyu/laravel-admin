<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoryList(Request $request)
    {
        $keyword = $request->get('keyword');
        $productCategoryList = $this->categoryRepository->getProductCategoryList($keyword);
        return $this->success($productCategoryList->toArray());
    }

    public function deleteCategory(Request $request, $categoryId)
    {
        $category = $this->categoryRepository->getCategoryById($categoryId);
        if (!$category) {
            return $this->error('分类不存在');
        }
        $res = $this->categoryRepository->deleteCategory($categoryId);
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
            'parent_id' => 'sometimes|integer'
        ];
        $messages = [
            'category_name.required' => '分类名称不可以为空',
            'description.required' => '密码不可以为空',
            'parent_id.integer' => '父级分类id必须大于0',
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }
        $category = $this->categoryRepository->getCategoryByName($request->get('category_name'));
        if ($category) {
            return $this->error('分类已经存在');
        }
        $res = $this->categoryRepository->addCategory($request->all());
        if ($res) {
            return $this->success();
        }
        return $this->error();
    }
}

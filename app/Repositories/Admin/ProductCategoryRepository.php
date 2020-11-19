<?php


namespace App\Repositories\Admin;


use App\Models\ProductCategory;

class ProductCategoryRepository
{
    public function getProductCategoryList($keyword = null)
    {
        return ProductCategory::orderby('id', 'desc')
            ->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('category_name', 'like', "%$keyword%");
                }
            })
            ->paginate();
    }

    public function getCategoryByName($categoryName)
    {
        return ProductCategory::where('category_name', '=', $categoryName)->first();
    }

    public function getCategoryById($categoryId)
    {
        return ProductCategory::find($categoryId);
    }

    public function deleteCategory($categoryId)
    {
        return ProductCategory::where('id', '=', $categoryId)->delete();
    }

    public function addCategory($category)
    {
        return ProductCategory::create($category);
    }
}

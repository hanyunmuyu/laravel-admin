<?php


namespace App\Repositories\Admin;


use App\Models\ProductCategory;

class ProductCategoryRepository
{
    public function getProductCategoryList()
    {
        return ProductCategory::orderby('id', 'desc')
            ->paginate();
    }

    public function getCategoryById($categoryId)
    {
        return ProductCategory::find($categoryId);
    }

    public function deleteCategory($categoryId)
    {
        return ProductCategory::where('id', '=', $categoryId)->delete();
    }
}

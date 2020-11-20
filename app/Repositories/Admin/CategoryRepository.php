<?php


namespace App\Repositories\Admin;


use App\Models\Category;

class CategoryRepository
{
    public function getProductCategoryList($keyword = null)
    {
        return Category::orderby('id', 'desc')
            ->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('category_name', 'like', "%$keyword%");
                }
            })
            ->paginate();
    }

    public function getCategoryByName($categoryName)
    {
        return Category::where('category_name', '=', $categoryName)->first();
    }

    public function getCategoryById($categoryId)
    {
        return Category::find($categoryId);
    }

    public function deleteCategory($categoryId)
    {
        return Category::where('id', '=', $categoryId)->delete();
    }

    public function addCategory($category)
    {
        return Category::create($category);
    }

    public function getAllCategory()
    {
        return Category::where('status', '=', 1)->get();
    }
}

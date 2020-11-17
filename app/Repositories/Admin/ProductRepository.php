<?php


namespace App\Repositories\Admin;


use App\Models\Product;

class ProductRepository
{
    public function getProductList()
    {
        return Product::orderby('id', 'desc')
            ->paginate();
    }

    public function getProductById($productId)
    {
        return Product::find($productId);
    }

    public function deleteProduct($productId)
    {
        return Product::where('id', '=', $productId)->delete();
    }
}

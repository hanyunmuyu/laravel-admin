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
}

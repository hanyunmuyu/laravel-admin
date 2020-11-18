<?php


namespace App\Repositories\Admin;


use App\Models\Product;
use App\Models\ProductImg;

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

    public function getProductByProductName($productName)
    {
        return Product::where('product_name', '=', $productName)->first();
    }

    public function deleteProduct($productId)
    {
        return Product::where('id', '=', $productId)->delete();
    }

    public function addProduct($data)
    {
        return Product::create($data);
    }

    public function addProductImg($data)
    {
        return ProductImg::insert($data);
    }

    public function deleteProductImg($productId)
    {
        return ProductImg::where('product_id', '=', $productId)->delete();
    }
    public function getProductImgList($productId)
    {
        return ProductImg::where('product_id', '=', $productId)->get();
    }

    public function updateProduct($productId, $product)
    {
        return Product::where('id', '=', $productId)->update($product);
    }
}

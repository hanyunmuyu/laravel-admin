<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductList(Request $request)
    {
        $productList = $this->productRepository->getProductList();
        return $this->success($productList->toArray());
    }

    public function deleteProduct($productId)
    {
        $product = $this->productRepository->getProductById($productId);
        if (!$product) {
            return $this->error('产品不存在');
        }
        if ($this->productRepository->deleteProduct($productId)) {
            return $this->success();
        }
        return $this->error();

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function addProduct(Request $request)
    {
        $rules = [
            'product_name' => 'required',
            'description' => 'required',
            'model' => 'required',
            'price' => 'required|min:0|integer',
            'quantity' => 'required|min:0|integer',
        ];
        $messages = [
            'product_name.required' => '用户名不可以为空',
            'description.required' => '密码不可以为空',
            'model.required' => '产品型号不可以为空',
            'price.required' => '价格不可以为空',
            'integer.required' => '价格必须为数字',
            'quantity.required' => '数量不可以为空',
            'quantity.integer' => '数量必须为数字',
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );
        if ($validator->fails()) {
            return $this->error($this->formatErrorMsg($validator->errors()));
        }

        $productName = $request->get('product_name');
        $product = $this->productRepository->getProductByProductName($productName);
        if ($product) {
            return $this->error('产品已经存在');
        }
        $res = $this->productRepository->addProduct($request->all());
        if ($res) {
            $data = [];
            $imgList = $request->get('imgList');
            foreach ($imgList as $img) {
                $tmp = [];
                $tmp['product_id'] = $res->id;
                $tmp['img_url'] = $img;
                $data[] = $tmp;
            }
            if ($data) {
                $this->productRepository->addProductImg($data);
            }
            return $this->success();
        }
        return $this->error('服务端错误，请重试！');
    }

    public function getProductDetail($productId)
    {
        $product = $this->productRepository->getProductById($productId);
        if (!$product) {
            return $this->error('产品不存在');
        }
        $product->imgList = $this->productRepository->getProductImgList($productId)->toArray();
        return $this->success($product->toArray());
    }
}

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
        $keyword = $request->get('keyword');
        $productList = $this->productRepository->getProductList($keyword);
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
//        0: {option_value_id: 2, quantity: 1, sub_stock: 0, add_price: 1}

        $rules = [
            'product_name' => 'required',
            'description' => 'required',
            'model' => 'required',
            'price' => 'required|min:0|integer',
            'quantity' => 'required|min:0|integer',
        ];
        $messages = [
            'product_name.required' => '产品名称不可以为空',
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
        $res = $this->productRepository->addProduct($request->except('categoryIds'));
        $optionList = $request->get('optionList');
        if ($optionList) {
            foreach ($optionList as $key => $option) {
                $option['product_id'] = $res->id;
                $optionList[$key] = $option;
            }
            $this->productRepository->addProductOption($optionList);
        }
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
            $categoryIds = $request->get('categoryIds');
            if ($categoryIds) {
                $categories = [];
                foreach ($categoryIds as $categoryId) {
                    $tmp = [];
                    $tmp['category_id'] = $categoryId;
                    $tmp['product_id'] = $res->id;
                    $categories[] = $tmp;
                }
                if ($categories) {
                    $this->productRepository->addProductCategory($categories);
                }
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
        $product->categoryIds = $this->productRepository->getProductCategoryList($productId)->pluck('category_id');
        return $this->success($product->toArray());
    }

    public function updateProduct(Request $request, $productId)
    {
        $product = $this->productRepository->getProductById($productId);
        if (!$product) {
            return $this->error('产品不存在');
        }
        $data = $request->except(['imgList', 'categoryIds']);
        $imgList = $request->get('imgList');
        if ($imgList && is_array($imgList)) {
            $imgData = [];
            foreach ($imgList as $img) {
                $tmp = [];
                $tmp['product_id'] = $productId;
                $tmp['img_url'] = $img;
                $imgData[] = $tmp;
            }
            if ($imgData) {
                $this->productRepository->deleteProductImg($productId);
                $this->productRepository->addProductImg($imgData);
            }
        }
        $res = $this->productRepository->updateProduct($productId, $data);
        $categoryIds = $request->get('categoryIds');
        if ($categoryIds) {
            $categories = [];
            foreach ($categoryIds as $categoryId) {
                $tmp = [];
                $tmp['category_id'] = $categoryId;
                $tmp['product_id'] = $productId;
                $categories[] = $tmp;
            }
            if ($categories) {
                $this->productRepository->deleteProductCategory($productId);
                $this->productRepository->addProductCategory($categories);
            }
        }
        if ($res) {
            return $this->success();
        }
        return $this->error('更新失败！');
    }
}

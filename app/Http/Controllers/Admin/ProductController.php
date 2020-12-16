<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\BrandRepository;
use App\Repositories\Admin\OptionRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    private $productRepository;
    private $optionRepository;
    private $brandRepository;
    public function __construct(ProductRepository $productRepository, OptionRepository $optionRepository,BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->optionRepository = $optionRepository;
        $this->brandRepository = $brandRepository;
    }

    public function getProductList(Request $request)
    {
        $keyword = $request->get('keyword');
        $productList = $this->productRepository->getProductList($keyword);
        foreach ($productList as $key => $product) {
            $brand = $this->brandRepository->getBrandById($product->brand_id);
            if ($brand) {
                $product->brand = $brand;
            }else{
                $product->brand = new \stdClass();
            }
        }
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
                $detail = $this->productRepository->getOptionValueDetail($option['option_value_id']);
                if ($detail) {
                    $option['product_id'] = $res->id;
                    $option['option_id'] = $detail->option_id;
                    $optionList[$key] = $option;
                }
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
        $data = $request->except(['imgList', 'categoryIds', 'optionList']);
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
        $optionList = $request->get('optionList');
        if ($optionList) {
            $optionValueIdList = [];
            foreach ($optionList as $key => $option) {
                $detail = $this->productRepository->getOptionValueDetail($option['option_value_id']);
                if ($detail) {
                    $optionValueIdList[] = $option['option_value_id'];
                    $option['product_id'] = $productId;
                    $option['option_id'] = $detail->option_id;
                    $optionList[$key] = $option;
                }

            }
            if ($optionValueIdList) {
                $productOptionList = $this->optionRepository->getOptionValueListByIdList($optionValueIdList);
                $this->productRepository->deleteProductOptionByOptionIdList($productOptionList->pluck('option_id'));
            }
            $this->productRepository->addProductOption($optionList);
        }
        if ($res) {
            return $this->success();
        }
        return $this->error('更新失败！');
    }

    public function getProductOption($productId)
    {
        $productOptionList = $this->productRepository->getProductOptionByProductId($productId);
        return $this->success($this->_generateProductOptionGroup($productOptionList->toArray()));
    }

    private function _generateProductOptionGroup($productOptionList)
    {
        $data = [];
        foreach ($productOptionList as $productOption) {
            $data[$productOption['option_id']][] = $productOption;
        }
        return array_values($data);
    }
}

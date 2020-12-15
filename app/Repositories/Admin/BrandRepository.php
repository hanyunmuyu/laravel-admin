<?php


namespace App\Repositories\Admin;


use App\Models\Brand;

class BrandRepository
{
    public function getBrandList()
    {
        return Brand::paginate();
    }

    public function deleteBrand($brandId)
    {
        return Brand::where('id', '=', $brandId)->delete();
    }

    public function getBrandById($brandId)
    {
        return Brand::find($brandId);
    }

    public function updateBrand($brandId, $data)
    {
        return Brand::where('id', '=', $brandId)
            ->update($data);
    }
}

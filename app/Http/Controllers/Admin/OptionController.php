<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\OptionRepository;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    //
    private $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function getOptionList(Request $request)
    {
        $optionList = $this->optionRepository->getAllOption();
        return $this->success($optionList->toArray());
    }

    public function getOptionDetail(Request $request, $optionId)
    {
        $option = $this->optionRepository->getOptionById($optionId);
        $option->valueList = $this->optionRepository->getOptionValueList($optionId)->toArray();
        return $this->success($option->toArray());
    }

    public function getOptionTypeList()
    {
        $optionTypeList = $this->optionRepository->getOptionTypeList();
        $group = $this->_generateOptionTypeGroup($optionTypeList->toArray());
        return $this->success($group);
    }

    private function _generateOptionTypeGroup($optionTypeList, $parentId = 0)
    {
        $data = [];
        foreach ($optionTypeList as $value) {
            if ($value['parent_id'] == $parentId) {
                $value['children'] = $this->_generateOptionTypeGroup($optionTypeList, $value['id']);
                $data[] = $value;
            }
        }
        return $data;
    }
}

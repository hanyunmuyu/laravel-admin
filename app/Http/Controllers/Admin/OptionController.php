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

    public function updateOption(Request $request, $optionId)
    {
        $option = $this->optionRepository->getOptionById($optionId);
        if (!$option) {
            return $this->error('选项不存在');
        }
        $this->optionRepository->updateOption($optionId, $request->only(['name', 'type', 'description']));
        $optionValueList = $request->get('valueList');
        $data = [];
        foreach ($optionValueList as $value) {
            $tmp = [];
            $tmp['option_id'] = $optionId;
            $tmp['value'] = $value['value'];
            $tmp['sort_order'] = $value['sortOrder'];
            $data[] = $tmp;
        }
        if ($data) {
            $this->optionRepository->deleteOptionValue($optionId);
            $this->optionRepository->addOptionValue($data);
        }
        return $this->success();
    }

    public function addOption(Request $request)
    {
        $res = $this->optionRepository->addOption($request->only(['name', 'type', 'description']));
        if ($res) {
            $optionValueList = $request->get('valueList');
            $data = [];
            foreach ($optionValueList as $value) {
                $tmp = [];
                $tmp['option_id'] = $res->id;
                $tmp['value'] = $value['value'];
                $tmp['sort_order'] = $value['sortOrder'];
                $data[] = $tmp;
            }
            if ($data) {
                $this->optionRepository->addOptionValue($data);
            }
        }
        return $this->success();
    }
}

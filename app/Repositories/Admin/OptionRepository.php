<?php


namespace App\Repositories\Admin;


use App\Models\Option;
use App\Models\OptionType;
use App\Models\OptionValue;

class OptionRepository
{
    public function getAllOption()
    {
        return Option::all();
    }

    public function getOptionById($optionId)
    {
        return Option::find($optionId);
    }

    public function getOptionValueList($optionId)
    {
        return OptionValue::where('option_id', '=', $optionId)->get();
    }

    public function getOptionTypeList()
    {
        return OptionType::all();
    }

    public function updateOption($optionId, $data)
    {
        return Option::where('id', '=', $optionId)->update($data);
    }

    public function deleteOptionValue($optionId)
    {
        return OptionValue::where('option_id', '=', $optionId)->delete();
    }

    public function addOptionValue($data)
    {
        return OptionValue::insert($data);
    }
}

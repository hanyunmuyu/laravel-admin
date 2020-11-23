<?php


namespace App\Repositories\Admin;


use App\Models\Option;
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
}

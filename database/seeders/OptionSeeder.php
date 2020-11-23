<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $optionList = [
            [
                'type' => 'radio',
                'name' => '单选',
                'description' => '智能选择一个'
            ],
            [
                'type' => 'checkbox',
                'name' => '复选框',
                'description' => '选择多个'

            ],
            [
                'type' => 'select',
                'name' => '下拉框',
                'description' => '下拉选择一个'

            ]
        ];
        Option::insert($optionList);
    }
}

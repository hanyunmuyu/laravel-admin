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
                'name' => '颜色',
                'description' => '智能选择一个'
            ],
            [
                'type' => 'radio',
                'name' => '内存',
                'description' => '智能选择一个'
            ],
            [
                'type' => 'checkbox',
                'name' => '保险',
                'description' => '选多个'
            ],
        ];
        Option::insert($optionList);
    }
}

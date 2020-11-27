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
                'is_single' => 1,
                'description' => '多个里面选择一个'
            ],
            [
                'type' => 'radio',
                'name' => '内存',
                'is_single' => 1,
                'description' => '多个里面选择一个'
            ],
            [
                'type' => 'checkbox',
                'name' => '保险',
                'is_single' => 0,
                'description' => '多个里面选择多个'
            ],
        ];
        Option::insert($optionList);
    }
}

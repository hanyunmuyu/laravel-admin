<?php

namespace Database\Seeders;

use App\Models\OptionType;
use Illuminate\Database\Seeder;

class OptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $optionTypeList = [
            [
                'type' => '',
                'name' => '选择框',
                'is_single' => 0,
                'children' => [
                    [
                        'type' => 'radio',
                        'name' => '单选框',
                        'is_single' => 1,
                        'description' => '只能选择一个'
                    ],
                    [
                        'type' => 'checkbox',
                        'name' => '复选框',
                        'is_single' => 0,
                        'description' => '选择多个'
                    ],
                    [
                        'type' => 'select',
                        'name' => '下拉框',
                        'is_single' => 1,
                        'description' => '只能选择一个'
                    ]
                ]
            ],
            [
                'type' => '',
                'name' => '输入框',
                'is_single' => 1,
                'children' => [
                    [
                        'type' => 'input',
                        'name' => '文本框',
                        'is_single' => 1,
                        'description' => '输入少量文字'
                    ],
                    [
                        'type' => 'textarea',
                        'name' => '文本域',
                        'is_single' => 1,
                        'description' => '输入多行文字'
                    ]
                ]
            ]

        ];
        foreach ($optionTypeList as $optionType) {
            $t = $optionType;
            unset($optionType['children']);
            $res = OptionType::create($optionType);
            if (isset($t['children'])) {
                $tmp = $t['children'];
                foreach ($tmp as $k => $v) {
                    $v['parent_id'] = $res->id;
                    $tmp[$k] = $v;
                }
                OptionType::insert($tmp);
            }
        }
    }
}

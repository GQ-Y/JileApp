<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

class InitCodeGeneratorMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent = \App\Model\Permission\Menu::create([
            'name'  => 'tools::code_generator',
            'path'  =>  '/plugin/code-generator-mine2',
            'icon'  => 'el-icon-s-tools',
            // todo 代码生成器前端页面组件
            'component' => 'plugins/mine-admin/code-generator/views/index.vue',
            'meta'  =>  new \App\Model\Permission\Meta([
                'type' => 'M',
                'title' => '代码生成器',
                'i18n' => 'tools.code_generator',
                'icon' => 'material-symbols:manage-accounts-outline',
                'hidden' => 0,
                // todo 代码生成器前端页面组件
                'componentPath' => 'modules/',
                'componentSuffix' => '.vue',
                'breadcrumbEnable' => 1,
                'copyright' => 1,
                'cache' => 1,
                'affix' => 0,
            ]),
        ]);
//        \App\Model\Permission\Menu::create([
//            'parent_id' =>  $parent->id,
//            'name'  => 'tools::code_generator::getTableInfo',
//            'meta'  =>  new \App\Model\Permission\Meta([
//                'type' => 'F',
//                'title' => '获取表信息',
//                'i18n' => 'tools.code_generator.getTableInfo',
//                'icon' => 'material-symbols:manage-accounts-outline',
//                'hidden' => 0,
//                'cache' => 1,
//                'affix' => 0,
//            ])
//        ]);
    }
}

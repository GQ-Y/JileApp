<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace Plugin\Cms\Database\Seeder;

use Hyperf\Database\Seeders\Seeder;
use Plugin\Cms\Model\Position\JileappCmsAdPosition;
use Hyperf\DbConnection\Db;

class JileappCmsAdPosition_seeder_20241120 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            // 检查表是否存在，如果不存在则创建
            if (!$this->checkTableExists('jileapp_cms_ad_position')) {
                $this->createTable();
            }

            // 禁用外键约束
            Db::statement('SET FOREIGN_KEY_CHECKS=0;');

            // 预定义广告位数据
            $positions = [
                [
                    'name_title' => '头部广告位',
                    'code_title' => 'header_ad',
                    'description_text' => '网站顶部横幅广告位，适合展示重要的推广内容',
                    'type_radio' => 3,
                    'width_title' => 1200,
                    'height_title' => 120,
                ],
                [
                    'name_title' => '首页轮播广告位',
                    'code_title' => 'home_slider_ad',
                    'description_text' => '首页顶部大图轮播广告位，展示重点推广内容',
                    'type_radio' => 3,
                    'width_title' => 1920,
                    'height_title' => 400,
                ],
                [
                    'name_title' => '右侧边栏广告位',
                    'code_title' => 'sidebar_right_ad',
                    'description_text' => '网站右侧固定广告位，可展示小图广告',
                    'type_radio' => 3,
                    'width_title' => 300,
                    'height_title' => 250,
                ],
                [
                    'name_title' => '文章内容页广告位',
                    'code_title' => 'article_content_ad',
                    'description_text' => '文章内容页中嵌入的广告位',
                    'type_radio' => 3,
                    'width_title' => 728,
                    'height_title' => 90,
                ],
                [
                    'name_title' => '弹窗广告位',
                    'code_title' => 'popup_ad',
                    'description_text' => '网站弹窗广告，用于展示重要通知或推广',
                    'type_radio' => 5,
                    'width_title' => 800,
                    'height_title' => 600,
                ],
                [
                    'name_title' => '底部广告位',
                    'code_title' => 'footer_ad',
                    'description_text' => '网站底部通栏广告位',
                    'type_radio' => 2,
                    'width_title' => 1200,
                    'height_title' => 100,
                ],
            ];

            // 批量创建或更新广告位
            foreach ($positions as $position) {
                // 检查是否存在相同的 code_title
                $existingPosition = JileappCmsAdPosition::query()
                    ->where('code_title', $position['code_title'])
                    ->withTrashed() // 包括软删除的记录
                    ->first();

                if ($existingPosition) {
                    // 如果记录存在，则更新
                    $existingPosition->fill(array_merge($position, [
                        'status_switch' => '1',
                        'updated_by' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'deleted_at' => null, // 恢复软删除的记录
                    ]))->save();
                } else {
                    // 如果记录不存在，则创建新记录
                    JileappCmsAdPosition::create(array_merge($position, [
                        'status_switch' => '1',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]));
                }
            }
        } finally {
            // 确保在任何情况下都重新启用外键约束
            Db::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * 检查表是否存在
     */
    private function checkTableExists(string $tableName): bool
    {
        return Db::select("SHOW TABLES LIKE '{$tableName}'") ? true : false;
    }

    /**
     * 创建表
     */
    private function createTable(): void
    {
        Db::statement("
            CREATE TABLE IF NOT EXISTS `jileapp_cms_ad_position` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `name_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
                `code_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '调用代码',
                `description_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
                `type_radio` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型:1=文本,2=链接,3=图片,4=视频,5=代码',
                `width_title` int(11) DEFAULT NULL COMMENT '宽度',
                `height_title` int(11) DEFAULT NULL COMMENT '高度',
                `status_switch` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1=启用,2=停用',
                `created_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建者',
                `updated_by` bigint(20) unsigned DEFAULT NULL COMMENT '更新者',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `deleted_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `jileapp_cms_ad_position_code_title_unique` (`code_title`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='广告位表';
        ");
    }
}

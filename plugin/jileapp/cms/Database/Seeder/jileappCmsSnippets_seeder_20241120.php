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
use Hyperf\DbConnection\Db;
use Plugin\Cms\Model\Snippets\JileappCmsSnippet;

class JileappCmsSnippets_seeder_20241120 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            // 检查表是否存在，如果不存在则创建
            if (!$this->checkTableExists('jileapp_cms_snippets')) {
                $this->createTable();
            }

            // 禁用外键约束
            Db::statement('SET FOREIGN_KEY_CHECKS=0;');

            // 使用 delete 方法清空表
            JileappCmsSnippet::query()->delete();

            // 预定义网站基本信息数据
            $siteInfo = [
                [
                    'name' => '网站Logo',
                    'code' => 'logo_url',
                    'content' => 'https://example.com/logo.png',
                    'description' => '网站Logo地址',
                ],
                [
                    'name' => 'SEO标题',
                    'code' => 'seo_title',
                    'content' => '我的网站 - 最好的内容',
                    'description' => '网站SEO标题',
                ],
                [
                    'name' => 'SEO描述',
                    'code' => 'seo_description',
                    'content' => '这是一个提供优质内容的网站。',
                    'description' => '网站SEO描述',
                ],
                [
                    'name' => '版权信息',
                    'code' => 'copyright',
                    'content' => '© 2023 我的公司. 保留所有权利。',
                    'description' => '版权信息',
                ],
                [
                    'name' => '联系邮箱',
                    'code' => 'contact_email',
                    'content' => 'contact@example.com',
                    'description' => '联系邮箱',
                ],
                [
                    'name' => '联系电话',
                    'code' => 'contact_phone',
                    'content' => '+1234567890',
                    'description' => '联系电话',
                ],
            ];

            // 批量创建网站基本信息
            foreach ($siteInfo as $info) {
                JileappCmsSnippet::create(array_merge($info, [
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]));
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
            CREATE TABLE IF NOT EXISTS `jileapp_cms_snippets` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
                `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '调用代码',
                `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容:文本输入框',
                `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
                `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1=启用,2=停用',
                `created_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建者',
                `updated_by` bigint(20) unsigned DEFAULT NULL COMMENT '更新者',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `deleted_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `jileapp_cms_snippets_code_unique` (`code`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='固定代码表';
        ");
    }
}

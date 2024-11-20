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
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 创建标签表
        Schema::create('jileapp_cms_tag', function (Blueprint $table) {
            $table->id();
            $table->string('name_title', 50)->comment('标签名称');
            $table->string('slug_title', 50)->unique()->nullable()->comment('标签别名');
            $table->string('status_switch')->nullable()->comment('开关');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('文章标签表');
        });

        // 创建固定代码表
        Schema::create('jileapp_cms_snippets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('名称');
            $table->string('code', 50)->unique()->comment('调用代码');
            $table->text('content')->nullable()->comment('内容:文本输入框');
            $table->string('description')->nullable()->comment('描述');
            $table->tinyInteger('status')->default(1)->comment('状态:1=启用,2=停用');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('固定代码表');
        });

        // 创建分类表
        Schema::create('jileapp_cms_categorie', function (Blueprint $table) {
            $table->id();
            $table->string('name_title', 50)->comment('分类名称');
            $table->string('slug_title', 50)->unique()->nullable()->comment('分类别名');
            $table->text('description_text')->nullable()->comment('分类描述');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父分类ID');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('status_switch')->nullable()->comment('开关');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('文章分类表');
        });

        // 创建文章表
        Schema::create('jileapp_cms_article', function (Blueprint $table) {
            $table->id();
            $table->string('title_title', 200)->comment('文章标题');
            $table->string('slug_title', 200)->unique()->nullable()->comment('文章别名');
            $table->text('summary_text')->nullable()->comment('文章摘要');
            $table->longText('content_editor')->nullable()->comment('文章内容');
            $table->string('thumbnail_image')->nullable()->comment('缩略图');
            $table->unsignedBigInteger('category_id')->nullable()->comment('分类ID');
            $table->tinyInteger('status')->nullable()->comment('状态:0=草稿,1=发布,2=下架,3=存档');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('jileapp_cms_categorie');
            $table->comment('文章表');
        });

        // 创建文章标签关联表
        Schema::create('jileapp_cms_article_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->nullable()->comment('文章ID');
            $table->unsignedBigInteger('tag_id')->nullable()->comment('标签ID');
            $table->foreign('article_id')->references('id')->on('jileapp_cms_article');
            $table->foreign('tag_id')->references('id')->on('jileapp_cms_tag');
            $table->comment('文章与标签关联表');
        });

        // 创建广告位表
        Schema::create('jileapp_cms_ad_position', function (Blueprint $table) {
            $table->id();
            $table->string('name_title', 50)->comment('广告位名称');
            $table->string('code_title', 50)->unique()->comment('广告位代码');
            $table->string('description_text')->nullable()->comment('描述');
            $table->tinyInteger('type_radio')->nullable()->comment('类型:1=文本,2=链接,3=图片,4=视频,5=音频');
            $table->integer('width_title')->nullable()->comment('宽度');
            $table->integer('height_title')->nullable()->comment('高度');
            $table->string('status_switch')->nullable()->comment('开关');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('广告位表');
        });

        // 创建广告表
        Schema::create('jileapp_cms_advertisement', function (Blueprint $table) {
            $table->id();
            $table->string('title_title', 100)->comment('广告标题');
            $table->unsignedBigInteger('position_id')->nullable()->comment('广告位ID');
            $table->tinyInteger('type_radio')->nullable()->comment('类型:1=文本,2=链接,3=图片,4=视频');
            $table->string('textarea')->nullable()->comment('内容');
            $table->string('content_image')->nullable()->comment('图片上传');
            $table->string('video_file')->nullable()->comment('视频上传');
            $table->string('url_title')->nullable()->comment('链接地址');
            $table->timestamp('start_time')->nullable()->comment('开始时间');
            $table->timestamp('end_time')->nullable()->comment('结束时间');
            $table->string('status_switch')->nullable()->comment('开关');
            $table->integer('sort')->default(0)->comment('排序');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('position_id')->references('id')->on('jileapp_cms_ad_position');
            $table->comment('广告表');
        });
    }

    public function down(): void
    {
        // 删除表
        Schema::dropIfExists('jileapp_cms_advertisement');
        Schema::dropIfExists('jileapp_cms_ad_position');
        Schema::dropIfExists('jileapp_cms_article_tag');
        Schema::dropIfExists('jileapp_cms_article');
        Schema::dropIfExists('jileapp_cms_categorie');
        Schema::dropIfExists('jileapp_cms_snippets');
        Schema::dropIfExists('jileapp_cms_tag');
    }
}; 
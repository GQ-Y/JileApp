<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('code_generator', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_name')->comment('方案名称');
            $table->string('table_name')->comment('表名称');
            $table->json('fields')->comment('字段列表');
            $table->string('package_name')->comment('子模块名称')->nullable();
            $table->string('database_connection')->comment('数据库连接')->default('default');
            $table->string('menu_name')->comment('菜单名称');
            $table->string('menu_id')->comment('菜单标识');
            $table->bigInteger('menu_parent_id')->comment('父级菜单ID')->default(0);
            $table->string('remark')->comment('备注信息')->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_generator');
    }
};

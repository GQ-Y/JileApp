<?php

declare(strict_types=1);

namespace Plugin\NEK\CodeGenerator\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property string $table_name 表名称
 * @property string $fields 字段列表
 * @property string $package_name 子模块名称
 * @property string $database_connection 数据库连接
 * @property string $menu_name 菜单名称
 * @property string $menu_id 菜单标识
 * @property int $menu_parent_id 父级菜单ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class CodeGenerator extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'code_generator';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'table_name', 'fields', 'package_name', 'database_connection', 'menu_name', 'menu_id', 'menu_parent_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'menu_parent_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}

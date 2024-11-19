<?php

declare(strict_types=1);

namespace Plugin\Cms\Model\Categorie;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property string $name_title 分类名称
 * @property string $slug_title 分类别名
 * @property string $description_text 分类描述
 * @property int $parent_id 父分类ID
 * @property int $sort 排序
 * @property string $status_switch 开关
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class JileappCmsCategorie extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'jileapp_cms_categorie';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name_title', 'slug_title', 'description_text', 'parent_id', 'sort', 'status_switch', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'parent_id' => 'integer', 'sort' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}

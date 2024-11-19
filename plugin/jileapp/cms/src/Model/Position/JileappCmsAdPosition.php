<?php

declare(strict_types=1);

namespace Plugin\Cms\Model\Position;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property string $name_title 广告位名称
 * @property string $code_title 广告位代码
 * @property string $description_text 描述
 * @property int $type_radio 类型:1=文本,2=链接,3=图片,4=视频,5=音频
 * @property int $width_title 宽度
 * @property int $height_title 高度
 * @property string $status_switch 开关
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class JileappCmsAdPosition extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'jileapp_cms_ad_position';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name_title', 'code_title', 'description_text', 'type_radio', 'width_title', 'height_title', 'status_switch', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'type_radio' => 'integer', 'width_title' => 'integer', 'height_title' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}

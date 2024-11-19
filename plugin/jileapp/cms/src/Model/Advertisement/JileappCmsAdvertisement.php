<?php

declare(strict_types=1);

namespace Plugin\Cms\Model\Advertisement;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property string $title_title 广告标题
 * @property int $position_id 广告位ID
 * @property int $type_radio 类型:1=文本,2=链接,3=图片,4=视频
 * @property string $textarea 内容
 * @property string $content_image 图片上传
 * @property string $video_file 视频上传
 * @property string $url_title 链接地址
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 * @property string $status_switch 开关
 * @property int $sort 排序
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class JileappCmsAdvertisement extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'jileapp_cms_advertisement';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'title_title', 'position_id', 'type_radio', 'textarea', 'content_image', 'video_file', 'url_title', 'start_time', 'end_time', 'status_switch', 'sort', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'position_id' => 'integer', 'type_radio' => 'integer', 'sort' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}

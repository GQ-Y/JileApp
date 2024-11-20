<?php

declare(strict_types=1);

namespace Plugin\Cms\Model\Article;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;
use Plugin\Cms\Model\Tag\JileappCmsTag;
use Plugin\Cms\Model\ArticleTag\JileappCmsArticleTag;
use Plugin\Cms\Model\Category\JileappCmsCategory;
/**
 * @property int $id 
 * @property string $title_title 文章标题
 * @property string $slug_title 文章别名
 * @property string $summary_text 文章摘要
 * @property string $content_editor 文章内容
 * @property string $thumbnail_image 缩略图
 * @property int $category_id 分类ID
 * @property int $status 状态:0=草稿,1=发布,2=下架,3=存档
 * @property string $published_at 发布时间
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class JileappCmsArticle extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'jileapp_cms_article';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'title_title', 'slug_title', 'summary_text', 'content_editor', 'thumbnail_image', 'category_id', 'status', 'published_at', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'category_id' => 'integer', 'status' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 通过中间表获取标签
     */
    public function tags()
    {
        return $this->belongsToMany(
            JileappCmsTag::class,
            JileappCmsArticleTag::class,
            'article_id',
            'tag_id'
        );
    }

    /**
     * 通过分类ID获取分类名称
     */
    public function categoryName()
    {
        return $this->belongsTo(JileappCmsCategory::class, 'category_id', 'id')->value('name_title');
    }
}

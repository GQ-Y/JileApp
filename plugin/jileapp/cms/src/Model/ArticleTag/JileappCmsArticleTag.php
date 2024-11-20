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

namespace Plugin\Cms\Model\ArticleTag;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property int $article_id 文章ID
 * @property int $tag_id 标签ID
 */
class JileappCmsArticleTag extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'jileapp_cms_article_tag';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'article_id', 'tag_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'article_id' => 'integer', 'tag_id' => 'integer'];
}

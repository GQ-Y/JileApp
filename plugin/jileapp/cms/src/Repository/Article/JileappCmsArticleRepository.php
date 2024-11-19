<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace Plugin\Cms\Repository\Article;

use App\Repository\IRepository;
use Hyperf\Database\Model\Builder;
use Plugin\Cms\Model\Article\JileappCmsArticle;

/**
 * 文章表 Repository类
 */
class JileappCmsArticleRepository extends IRepository
{
   public function __construct(
        protected readonly JileappCmsArticle $model
    ) {}

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // id
        if (isset($params['id']) && filled($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        // 文章标题
        if (isset($params['title_title']) && filled($params['title_title'])) {
            $query->where('title_title', 'like', '%'.$params['title_title'].'%');
        }

        // 文章别名
        if (isset($params['slug_title']) && filled($params['slug_title'])) {
            $query->where('slug_title', 'like', '%'.$params['slug_title'].'%');
        }

        // 文章摘要
        if (isset($params['summary_text']) && filled($params['summary_text'])) {
            $query->where('summary_text', '=', $params['summary_text']);
        }

        // 文章内容
        if (isset($params['content_editor']) && filled($params['content_editor'])) {
            $query->where('content_editor', '=', $params['content_editor']);
        }

        // 缩略图
        if (isset($params['thumbnail_image']) && filled($params['thumbnail_image'])) {
            $query->where('thumbnail_image', '=', $params['thumbnail_image']);
        }

        // 分类ID
        if (isset($params['category_id']) && filled($params['category_id'])) {
            $query->where('category_id', '=', $params['category_id']);
        }

        // 状态
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        // 发布时间
        if (isset($params['published_at']) && filled($params['published_at']) && is_array($params['published_at']) && count($params['published_at']) == 2) {
            $query->whereBetween(
                'published_at',
                [ $params['published_at'][0], $params['published_at'][1] ]
            );
        }

        // 创建者
        if (isset($params['created_by']) && filled($params['created_by'])) {
            $query->where('created_by', '=', $params['created_by']);
        }

        // 更新者
        if (isset($params['updated_by']) && filled($params['updated_by'])) {
            $query->where('updated_by', '=', $params['updated_by']);
        }

        // 创建时间
        if (isset($params['created_at']) && filled($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0], $params['created_at'][1] ]
            );
        }

        // 更新时间
        if (isset($params['updated_at']) && filled($params['updated_at']) && is_array($params['updated_at']) && count($params['updated_at']) == 2) {
            $query->whereBetween(
                'updated_at',
                [ $params['updated_at'][0], $params['updated_at'][1] ]
            );
        }

        // 删除时间
        if (isset($params['deleted_at']) && filled($params['deleted_at']) && is_array($params['deleted_at']) && count($params['deleted_at']) == 2) {
            $query->whereBetween(
                'deleted_at',
                [ $params['deleted_at'][0], $params['deleted_at'][1] ]
            );
        }

        return $query;
    }
}
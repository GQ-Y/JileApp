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

namespace Plugin\Cms\Repository\Categorie;

use App\Repository\IRepository;
use Hyperf\Database\Model\Builder;
use Plugin\Cms\Model\Categorie\JileappCmsCategorie;

/**
 * 文章分类表 Repository类
 */
class JileappCmsCategorieRepository extends IRepository
{
   public function __construct(
        protected readonly JileappCmsCategorie $model
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

        // 分类名称
        if (isset($params['name_title']) && filled($params['name_title'])) {
            $query->where('name_title', 'like', '%'.$params['name_title'].'%');
        }

        // 分类别名
        if (isset($params['slug_title']) && filled($params['slug_title'])) {
            $query->where('slug_title', 'like', '%'.$params['slug_title'].'%');
        }

        // 分类描述
        if (isset($params['description_text']) && filled($params['description_text'])) {
            $query->where('description_text', 'like', '%'.$params['description_text'].'%');
        }

        // 父分类ID
        if (isset($params['parent_id']) && filled($params['parent_id'])) {
            $query->where('parent_id', '=', $params['parent_id']);
        }

        // 排序
        if (isset($params['sort']) && filled($params['sort'])) {
            $query->where('sort', '=', $params['sort']);
        }

        // 开关
        if (isset($params['status_switch']) && filled($params['status_switch'])) {
            $query->where('status_switch', 'like', '%'.$params['status_switch'].'%');
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
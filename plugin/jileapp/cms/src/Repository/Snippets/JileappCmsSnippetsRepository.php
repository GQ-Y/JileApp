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

namespace Plugin\Cms\Repository\Snippets;

use App\Repository\IRepository;
use Hyperf\Database\Model\Builder;
use Plugin\Cms\Model\Snippets\JileappCmsSnippet;

/**
 * 固定代码表 Repository类.
 */
class JileappCmsSnippetsRepository extends IRepository
{
    public function __construct(
        protected readonly JileappCmsSnippet $model
    ) {}

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // id
        if (isset($params['id']) && filled($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        // 名称
        if (isset($params['name']) && filled($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        // 调用代码
        if (isset($params['code']) && filled($params['code'])) {
            $query->where('code', 'like', '%' . $params['code'] . '%');
        }

        // 内容
        if (isset($params['content']) && filled($params['content'])) {
            $query->where('content', '=', $params['content']);
        }

        // 描述
        if (isset($params['description']) && filled($params['description'])) {
            $query->where('description', 'like', '%' . $params['description'] . '%');
        }

        // 状态
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', '=', $params['status']);
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
        if (isset($params['created_at']) && filled($params['created_at']) && \is_array($params['created_at']) && \count($params['created_at']) === 2) {
            $query->whereBetween(
                'created_at',
                [$params['created_at'][0], $params['created_at'][1]]
            );
        }

        // 更新时间
        if (isset($params['updated_at']) && filled($params['updated_at']) && \is_array($params['updated_at']) && \count($params['updated_at']) === 2) {
            $query->whereBetween(
                'updated_at',
                [$params['updated_at'][0], $params['updated_at'][1]]
            );
        }

        // 删除时间
        if (isset($params['deleted_at']) && filled($params['deleted_at']) && \is_array($params['deleted_at']) && \count($params['deleted_at']) === 2) {
            $query->whereBetween(
                'deleted_at',
                [$params['deleted_at'][0], $params['deleted_at'][1]]
            );
        }

        return $query;
    }
}

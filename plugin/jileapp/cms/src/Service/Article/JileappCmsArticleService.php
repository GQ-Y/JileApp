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

namespace Plugin\Cms\Service\Article;

use App\Service\IService;
use Plugin\Cms\Model\ArticleTag\JileappCmsArticleTag;
use Plugin\Cms\Model\Categorie\JileappCmsCategorie;
use Plugin\Cms\Model\Tag\JileappCmsTag;
use Plugin\Cms\Repository\Article\JileappCmsArticleRepository;

/**
 * 文章表服务类.
 */
final class JileappCmsArticleService extends IService
{
    public function __construct(
        protected readonly JileappCmsArticleRepository $repository
    ) {}

    /**
     * 重写page方法，添加标签信息.
     */
    public function page(array $params = [], int $page = 1, int $pageSize = 15): array
    {
        // 获取文章列表
        $result = parent::page($params, $page, $pageSize);

        if (! empty($result['list'])) {
            // 获取所有文章ID
            $articleIds = array_column($result['list'], 'id');

            // 查询文章标签关联
            $articleTags = JileappCmsArticleTag::query()
                ->whereIn('article_id', $articleIds)
                ->get()
                ->groupBy('article_id')
                ->toArray();

            // 获取所有标签ID
            $tagIds = [];
            foreach ($articleTags as $tags) {
                foreach ($tags as $tag) {
                    $tagIds[] = $tag['tag_id'];
                }
            }

            // 查询标签信息
            $tags = JileappCmsTag::query()
                ->whereIn('id', array_unique($tagIds))
                ->get(['id', 'name_title'])
                ->keyBy('id')
                ->toArray();

            // 将标签信息添加到文章数据中
            foreach ($result['list'] as &$article) {
                $article['tags'] = [];
                if (isset($articleTags[$article['id']])) {
                    foreach ($articleTags[$article['id']] as $tag) {
                        if (isset($tags[$tag['tag_id']])) {
                            $article['tags'][] = $tags[$tag['tag_id']];
                        }
                    }
                }
            }
            // 获取所有文章的分类ID
            $categoryIds = array_unique(array_column($result['list'], 'category_id'));

            // 查询分类信息
            $categories = JileappCmsCategorie::query()
                ->whereIn('id', $categoryIds)
                ->get(['id', 'name_title'])
                ->keyBy('id')
                ->toArray();

            // 将分类名称添加到文章数据中
            foreach ($result['list'] as &$article) {
                $article['categoryName'] = $categories[$article['category_id']]['name_title'] ?? '';
            }
        }

        return $result;
    }
}

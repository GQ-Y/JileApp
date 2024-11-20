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

namespace Plugin\Cms\Controller\Article;

use App\Http\Admin\Controller\AbstractController as AdminAbstractController;
use App\Http\Admin\Middleware\PermissionMiddleware;
use App\Http\Common\Middleware\AccessTokenMiddleware;
use App\Http\Common\Result;
use App\Http\CurrentUser;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Request;
use Hyperf\Swagger\Annotation\Delete;
use Hyperf\Swagger\Annotation\Get;
use Hyperf\Swagger\Annotation\HyperfServer;
use Hyperf\Swagger\Annotation\JsonContent;
use Hyperf\Swagger\Annotation\Post;
use Hyperf\Swagger\Annotation\Put;
use Hyperf\Swagger\Annotation\RequestBody;
use Mine\Access\Attribute\Permission;
use Mine\Swagger\Attributes\PageResponse;
use Plugin\Cms\Model\ArticleTag\JileappCmsArticleTag;
use Plugin\Cms\Request\Article\JileappCmsArticleRequest;
use Plugin\Cms\Schema\Article\JileappCmsArticleSchema;
use Plugin\Cms\Service\Article\JileappCmsArticleService;

/**
 * 文章表控制器
 * Class JileappCmsArticleController.
 */
#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
final class JileappCmsArticleController extends AdminAbstractController
{
    /**
     * 业务处理服务
     * JileappCmsArticleService.
     */
    public function __construct(
        protected readonly JileappCmsArticleService $service,
        protected readonly CurrentUser $currentUser
    ) {}

    #[Get(
        path: '/article/jileappCmsArticle/list',
        operationId: 'ArticleJileappcmsarticleList',
        summary: '文章表控制器列表',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章表控制器'],
    )]
    #[Permission(code: 'article:jileappCmsArticle, article:jileappCmsArticle:index')]
    #[PageResponse(instance: JileappCmsArticleSchema::class)]
    public function page(Request $request): Result
    {
        return $this->success(data: $this->service->page(array_merge([
            'with' => ['tags:id,name_title', 'categoryName'],
        ], $request->all()), (int) $request->query('page'), (int) $request->query('page_size')));
    }

    #[Post(
        path: '/article/jileappCmsArticle',
        operationId: 'ArticleJileappcmsarticleCreate',
        summary: '创建文章表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章表控制器'],
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsArticleRequest::class, title: '创建文章表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'article:jileappCmsArticle:save')]
    public function create(JileappCmsArticleRequest $request): Result
    {
        try {
            Db::beginTransaction();

            // 创建文章
            $articleData = array_merge($request->post(), [
                'created_by' => $this->currentUser->id(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            // 从请求数据中移除tag_id,避免写入主表
            $tagIds = $articleData['tag_id'] ?? [];
            unset($articleData['tag_id']);

            // 创建文章并获取ID
            $article = $this->service->create($articleData);

            // 处理标签关联
            if (! empty($tagIds)) {
                foreach ($tagIds as $tagId) {
                    JileappCmsArticleTag::create([
                        'article_id' => $article->id,
                        'tag_id' => $tagId,
                    ]);
                }
            }

            Db::commit();
            return $this->success();
        } catch (\Throwable $e) {
            Db::rollBack();
            return $this->error($e->getMessage());
        }
    }

    #[Put(
        path: '/article/jileappCmsArticle/{id}',
        operationId: 'ArticleJileappcmsarticleEdit',
        summary: '编辑文章表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章表控制器']
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsArticleRequest::class, title: '编辑文章表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'article:jileappCmsArticle:update')]
    public function save(int $id, JileappCmsArticleRequest $request): Result
    {
        $this->service->updateById($id, array_merge($request->post(), [
            'updated_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Delete(
        path: '/article/jileappCmsArticle',
        operationId: 'ArticleJileappcmsarticleDelete',
        summary: '删除文章表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章表控制器']
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'article:jileappCmsArticle:delete')]
    public function delete(): Result
    {
        $this->service->deleteById($this->getRequest()->all(), false);
        return $this->success();
    }
}

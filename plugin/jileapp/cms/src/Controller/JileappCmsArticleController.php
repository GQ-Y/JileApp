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

namespace Plugin\Cms\Controller;

use App\Http\Admin\Controller\AbstractController as AdminAbstractController;
use App\Http\Admin\Middleware\PermissionMiddleware;
use App\Http\Common\Middleware\AccessTokenMiddleware;
use App\Http\Common\Result;
use App\Http\CurrentUser;
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
use Plugin\Cms\Request\Article\JileappCmsArticleRequest;
use Plugin\Cms\Schema\Article\JileappCmsArticleSchema;
use Plugin\Cms\Service\Article\JileappCmsArticleService;

/**
 * 文章表控制器
 * Class JileappCmsArticleController
 */
#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
final class JileappCmsArticleController extends AdminAbstractController
{

     /**
     * 业务处理服务
     * JileappCmsArticleService
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
        $this->service->create(array_merge($request->post(), [
            'created_by' => $this->currentUser->id(),
        ]));
        return $this->success();
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
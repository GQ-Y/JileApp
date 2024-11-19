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

namespace Plugin\Cms\Controller\Tag;

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
use Plugin\Cms\Request\Tag\JileappCmsTagRequest;
use Plugin\Cms\Schema\Tag\JileappCmsTagSchema;
use Plugin\Cms\Service\Tag\JileappCmsTagService;

/**
 * 文章标签表控制器
 * Class JileappCmsTagController
 */
#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
final class JileappCmsTagController extends AdminAbstractController
{

     /**
     * 业务处理服务
     * JileappCmsTagService
     */
    public function __construct(
        protected readonly JileappCmsTagService $service,
        protected readonly CurrentUser $currentUser
    ) {}

    

    #[Get(
        path: '/tag/jileappCmsTag/list',
        operationId: 'TagJileappcmstagList',
        summary: '文章标签表控制器列表',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章标签表控制器'],
    )]
    #[Permission(code: 'tag:jileappCmsTag, tag:jileappCmsTag:index')]
    #[PageResponse(instance: JileappCmsTagSchema::class)]
    public function page(Request $request): Result
    {
        return $this->success(data: $this->service->page(array_merge([

        ], $request->all()), (int) $request->query('page'), (int) $request->query('page_size')));
    }


    #[Post(
        path: '/tag/jileappCmsTag',
        operationId: 'TagJileappcmstagCreate',
        summary: '创建文章标签表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章标签表控制器'],
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsTagRequest::class, title: '创建文章标签表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'tag:jileappCmsTag:save')]
    public function create(JileappCmsTagRequest $request): Result
    {
        $this->service->create(array_merge($request->post(), [
            'created_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Put(
        path: '/tag/jileappCmsTag/{id}',
        operationId: 'TagJileappcmstagEdit',
        summary: '编辑文章标签表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章标签表控制器']
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsTagRequest::class, title: '编辑文章标签表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'tag:jileappCmsTag:update')]
    public function save(int $id, JileappCmsTagRequest $request): Result
    {
        $this->service->updateById($id, array_merge($request->post(), [
            'updated_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Delete(
        path: '/tag/jileappCmsTag',
        operationId: 'TagJileappcmstagDelete',
        summary: '删除文章标签表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['文章标签表控制器']
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'tag:jileappCmsTag:delete')]
    public function delete(): Result
    {
      $this->service->deleteById($this->getRequest()->all(), false);
      return $this->success();
    }

}
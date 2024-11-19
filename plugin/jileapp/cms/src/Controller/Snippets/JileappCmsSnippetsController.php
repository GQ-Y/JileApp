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

namespace Plugin\Cms\Controller\Snippets;

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
use Plugin\Cms\Request\Snippets\JileappCmsSnippetsRequest;
use Plugin\Cms\Schema\Snippets\JileappCmsSnippetsSchema;
use Plugin\Cms\Service\Snippets\JileappCmsSnippetsService;

/**
 * 固定代码表控制器
 * Class JileappCmsSnippetsController.
 */
#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
final class JileappCmsSnippetsController extends AdminAbstractController
{
    /**
     * 业务处理服务
     * JileappCmsSnippetsService.
     */
    public function __construct(
        protected readonly JileappCmsSnippetsService $service,
        protected readonly CurrentUser $currentUser
    ) {}

    #[Get(
        path: '/snippets/jileappCmsSnippets/list',
        operationId: 'SnippetsJileappcmssnippetsList',
        summary: '固定代码表控制器列表',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['固定代码表控制器'],
    )]
    #[Permission(code: 'snippets:jileappCmsSnippets, snippets:jileappCmsSnippets:index')]
    #[PageResponse(instance: JileappCmsSnippetsSchema::class)]
    public function page(Request $request): Result
    {
        return $this->success(data: $this->service->page(array_merge([
        ], $request->all()), (int) $request->query('page'), (int) $request->query('page_size')));
    }

    #[Post(
        path: '/snippets/jileappCmsSnippets',
        operationId: 'SnippetsJileappcmssnippetsCreate',
        summary: '创建固定代码表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['固定代码表控制器'],
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsSnippetsRequest::class, title: '创建固定代码表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'snippets:jileappCmsSnippets:save')]
    public function create(JileappCmsSnippetsRequest $request): Result
    {
        $this->service->create(array_merge($request->post(), [
            'created_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Put(
        path: '/snippets/jileappCmsSnippets/{id}',
        operationId: 'SnippetsJileappcmssnippetsEdit',
        summary: '编辑固定代码表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['固定代码表控制器']
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsSnippetsRequest::class, title: '编辑固定代码表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'snippets:jileappCmsSnippets:update')]
    public function save(int $id, JileappCmsSnippetsRequest $request): Result
    {
        $this->service->updateById($id, array_merge($request->post(), [
            'updated_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Delete(
        path: '/snippets/jileappCmsSnippets',
        operationId: 'SnippetsJileappcmssnippetsDelete',
        summary: '删除固定代码表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['固定代码表控制器']
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'snippets:jileappCmsSnippets:delete')]
    public function delete(): Result
    {
        $this->service->deleteById($this->getRequest()->all(), false);
        return $this->success();
    }
}

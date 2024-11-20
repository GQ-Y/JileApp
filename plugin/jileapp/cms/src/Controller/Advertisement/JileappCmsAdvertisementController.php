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

namespace Plugin\Cms\Controller\Advertisement;

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
use Plugin\Cms\Request\Advertisement\JileappCmsAdvertisementRequest;
use Plugin\Cms\Schema\Advertisement\JileappCmsAdvertisementSchema;
use Plugin\Cms\Service\Advertisement\JileappCmsAdvertisementService;

/**
 * 广告表控制器
 * Class JileappCmsAdvertisementController.
 */
#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
final class JileappCmsAdvertisementController extends AdminAbstractController
{
    /**
     * 业务处理服务
     * JileappCmsAdvertisementService.
     */
    public function __construct(
        protected readonly JileappCmsAdvertisementService $service,
        protected readonly CurrentUser $currentUser
    ) {}

    #[Get(
        path: '/advertisement/jileappCmsAdvertisement/list',
        operationId: 'AdvertisementJileappcmsadvertisementList',
        summary: '广告表控制器列表',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告表控制器'],
    )]
    #[Permission(code: 'advertisement:jileappCmsAdvertisement, advertisement:jileappCmsAdvertisement:index')]
    #[PageResponse(instance: JileappCmsAdvertisementSchema::class)]
    public function page(Request $request): Result
    {
        return $this->success(data: $this->service->page(array_merge([
        ], $request->all()), (int) $request->query('page'), (int) $request->query('page_size')));
    }

    #[Post(
        path: '/advertisement/jileappCmsAdvertisement',
        operationId: 'AdvertisementJileappcmsadvertisementCreate',
        summary: '创建广告表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告表控制器'],
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsAdvertisementRequest::class, title: '创建广告表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'advertisement:jileappCmsAdvertisement:save')]
    public function create(JileappCmsAdvertisementRequest $request): Result
    {
        $this->service->create(array_merge($request->post(), [
            'created_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Put(
        path: '/advertisement/jileappCmsAdvertisement/{id}',
        operationId: 'AdvertisementJileappcmsadvertisementEdit',
        summary: '编辑广告表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告表控制器']
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsAdvertisementRequest::class, title: '编辑广告表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'advertisement:jileappCmsAdvertisement:update')]
    public function save(int $id, JileappCmsAdvertisementRequest $request): Result
    {
        $this->service->updateById($id, array_merge($request->post(), [
            'updated_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Delete(
        path: '/advertisement/jileappCmsAdvertisement',
        operationId: 'AdvertisementJileappcmsadvertisementDelete',
        summary: '删除广告表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告表控制器']
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'advertisement:jileappCmsAdvertisement:delete')]
    public function delete(): Result
    {
        $this->service->deleteById($this->getRequest()->all(), false);
        return $this->success();
    }
}

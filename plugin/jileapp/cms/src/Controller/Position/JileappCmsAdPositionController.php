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

namespace Plugin\Cms\Controller\Position;

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
use Plugin\Cms\Request\Position\JileappCmsAdPositionRequest;
use Plugin\Cms\Schema\Position\JileappCmsAdPositionSchema;
use Plugin\Cms\Service\Position\JileappCmsAdPositionService;

/**
 * 广告位表控制器
 * Class JileappCmsAdPositionController
 */
#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
final class JileappCmsAdPositionController extends AdminAbstractController
{

     /**
     * 业务处理服务
     * JileappCmsAdPositionService
     */
    public function __construct(
        protected readonly JileappCmsAdPositionService $service,
        protected readonly CurrentUser $currentUser
    ) {}

    

    #[Get(
        path: '/position/jileappCmsAdPosition/list',
        operationId: 'PositionJileappcmsadpositionList',
        summary: '广告位表控制器列表',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告位表控制器'],
    )]
    #[Permission(code: 'position:jileappCmsAdPosition, position:jileappCmsAdPosition:index')]
    #[PageResponse(instance: JileappCmsAdPositionSchema::class)]
    public function page(Request $request): Result
    {
        return $this->success(data: $this->service->page(array_merge([

        ], $request->all()), (int) $request->query('page'), (int) $request->query('page_size')));
    }


    #[Post(
        path: '/position/jileappCmsAdPosition',
        operationId: 'PositionJileappcmsadpositionCreate',
        summary: '创建广告位表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告位表控制器'],
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsAdPositionRequest::class, title: '创建广告位表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'position:jileappCmsAdPosition:save')]
    public function create(JileappCmsAdPositionRequest $request): Result
    {
        $this->service->create(array_merge($request->post(), [
            'created_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Put(
        path: '/position/jileappCmsAdPosition/{id}',
        operationId: 'PositionJileappcmsadpositionEdit',
        summary: '编辑广告位表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告位表控制器']
    )]
    #[RequestBody(
        content: new JsonContent(ref: JileappCmsAdPositionRequest::class, title: '编辑广告位表控制器')
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'position:jileappCmsAdPosition:update')]
    public function save(int $id, JileappCmsAdPositionRequest $request): Result
    {
        $this->service->updateById($id, array_merge($request->post(), [
            'updated_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Delete(
        path: '/position/jileappCmsAdPosition',
        operationId: 'PositionJileappcmsadpositionDelete',
        summary: '删除广告位表控制器',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['广告位表控制器']
    )]
    #[PageResponse(instance: new Result())]
    #[Permission(code: 'position:jileappCmsAdPosition:delete')]
    public function delete(): Result
    {
      $this->service->deleteById($this->getRequest()->all(), false);
      return $this->success();
    }

}
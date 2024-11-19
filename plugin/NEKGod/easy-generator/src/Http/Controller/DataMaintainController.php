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

namespace Plugin\NEK\CodeGenerator\Http\Controller;

use App\Http\Admin\Controller\AbstractController;
use App\Http\Admin\Middleware\PermissionMiddleware;
use App\Http\Common\Middleware\AccessTokenMiddleware;
use App\Http\Common\Middleware\OperationMiddleware;
use App\Http\Common\Result;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\Swagger\Annotation\Get;
use Hyperf\Swagger\Annotation\HyperfServer;
use Mine\Access\Attribute\Permission;
use Plugin\NEK\CodeGenerator\Service\DataMaintainService;

/**
 * Class DataMaintainController.
 */
#[HyperfServer(name: 'http')]
//#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
//#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
//#[Middleware(middleware: OperationMiddleware::class, priority: 98)]
class DataMaintainController extends AbstractController
{
    public function __construct(
        private readonly DataMaintainService $service
    ){}

    #[Get(
        path: '/plugin/codeGenerator/getTableInfo',
//        operationId: 'PluginMineAdminCodeGeneratorGetTableInfo',
        summary: '获取表信息',
        tags: ['代码生成器'],
    )]
//    #[Permission('tools::code_generator::getTableInfo')]
    public function getTableInfo(): Result
    {
        return $this->success($this->service->getPageList($this->getRequest()->all()));
    }

//    /**
//     * 详情.
//     * @throws ContainerExceptionInterface
//     * @throws NotFoundExceptionInterface
//     */
//    #[GetMapping('detailed'), Permission('system:dataMaintain:detailed')]
//    public function detailed(): ResponseInterface
//    {
//        return $this->success($this->service->getColumnList($this->request->input('table', null)));
//    }
//
//    /**
//     * 优化表.
//     * @throws ContainerExceptionInterface
//     * @throws NotFoundExceptionInterface
//     */
//    #[PostMapping('optimize'), Permission('system:dataMaintain:optimize'), OperationLog]
//    public function optimize(): ResponseInterface
//    {
//        $tables = $this->request->input('tables', []);
//        return $this->service->optimize($tables) ? $this->success() : $this->error();
//    }
//
//    /**
//     * 清理表碎片.
//     * @throws ContainerExceptionInterface
//     * @throws NotFoundExceptionInterface
//     */
//    #[PostMapping('fragment'), Permission('system:dataMaintain:fragment'), OperationLog]
//    public function fragment(): ResponseInterface
//    {
//        $tables = $this->request->input('tables', []);
//        return $this->service->fragment($tables) ? $this->success() : $this->error();
//    }
}

<?php

namespace Plugin\NEK\CodeGenerator\Http\Controller;

use App\Http\Admin\Controller\AbstractController;
use App\Http\Admin\Middleware\PermissionMiddleware;
use App\Http\Common\Middleware\AccessTokenMiddleware;
use App\Http\Common\Middleware\OperationMiddleware;
use App\Http\Common\Result;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\Swagger\Annotation\Get;
use Hyperf\Swagger\Annotation\HyperfServer;
use Mine\Access\Attribute\Permission;
use Mine\Swagger\Attributes\ListResponse;
use Plugin\NEK\CodeGenerator\Http\Request\GetTableInfoRequest;
use Plugin\NEK\CodeGenerator\Http\Vo\TableColumn;
use Plugin\NEK\CodeGenerator\Service\GeneratorService;

#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
#[Middleware(middleware: OperationMiddleware::class, priority: 98)]
class IndexController extends AbstractController
{
//    public function __construct(
//        private readonly GeneratorService $service
//    ){}

//    #[Get(
//        path: '/admin/plugin/code-generator/get-table-info',
//        operationId: 'PluginMineAdminCodeGeneratorGetTableInfo',
//        summary: '获取表信息',
//        tags: ['代码生成器'],
//    )]
//    #[Permission('tools::code_generator::getTableInfo')]
//    #[ListResponse(instance: TableColumn::class,example: '{"code":200,"message":"成功","data":[{"name":"id","type":"bigint","comment":"用户ID,主键"},{"name":"username","type":"string","comment":"用户名"},{"name":"password","type":"string","comment":"密码"},{"name":"user_type","type":"string","comment":"用户类型:100=系统用户"},{"name":"nickname","type":"string","comment":"用户昵称"},{"name":"phone","type":"string","comment":"手机"},{"name":"email","type":"string","comment":"用户邮箱"},{"name":"avatar","type":"string","comment":"用户头像"},{"name":"signed","type":"string","comment":"个人签名"},{"name":"dashboard","type":"string","comment":"后台首页类型"},{"name":"status","type":"boolean","comment":"状态:1=正常,2=停用"},{"name":"login_ip","type":"string","comment":"最后登陆IP"},{"name":"login_time","type":"datetime","comment":"最后登陆时间"},{"name":"backend_setting","type":"json","comment":"后台设置数据"},{"name":"created_by","type":"bigint","comment":"创建者"},{"name":"updated_by","type":"bigint","comment":"更新者"},{"name":"created_at","type":"datetime","comment":null},{"name":"updated_at","type":"datetime","comment":null},{"name":"remark","type":"string","comment":"备注"}]}')]
//    public function getTableInfo(GetTableInfoRequest $getTableInfoRequest): Result
//    {
//        $tableName = $getTableInfoRequest->all()['table_name'];
//        $databaseConnection = $getTableInfoRequest->all()['database_connection'];
//        return $this->success($this->service->getTableInfo($databaseConnection,$tableName));
//    }
}
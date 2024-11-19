<?php

namespace Plugin\MineAdmin\CodeGenerator\Http\Controller;

use App\Http\Admin\Controller\AbstractController;
use App\Http\Common\Middleware\AccessTokenMiddleware;
use App\Http\Common\Middleware\OperationMiddleware;
use App\Http\Common\Result;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Swagger\Annotation\Get;
use Hyperf\Swagger\Annotation\HyperfServer;
use Hyperf\Swagger\Annotation\Post;
use Mine\Access\Attribute\Permission;
use Mine\Swagger\Attributes\ListResponse;
use Plugin\MineAdmin\CodeGenerator\Constants\GeneratorType;
use Plugin\MineAdmin\CodeGenerator\Http\Request\GetTableInfoRequest;
use Plugin\MineAdmin\CodeGenerator\Http\Request\PreviewAndGeneratorRequest;
use Plugin\MineAdmin\CodeGenerator\Http\Request\SaveTableSettingRequest;
use Plugin\MineAdmin\CodeGenerator\Http\Vo\TableColumn;
use Plugin\MineAdmin\CodeGenerator\Service\GeneratorService;
use Psr\Http\Message\RequestInterface;

#[HyperfServer(name: 'http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: OperationMiddleware::class, priority: 98)]
class IndexController extends AbstractController
{
    public function __construct(
        private readonly GeneratorService $service
    ){}

    #[Get(
        path: '/admin/plugin/code-generator/get-table-info',
        operationId: 'PluginMineAdminCodeGeneratorGetTableInfo',
        summary: '获取表信息',
        tags: ['代码生成器'],
    )]
    #[ListResponse(instance: TableColumn::class,example: '{"code":200,"message":"成功","data":[{"name":"id","type":"bigint","comment":"用户ID,主键"},{"name":"username","type":"string","comment":"用户名"},{"name":"password","type":"string","comment":"密码"},{"name":"user_type","type":"string","comment":"用户类型:100=系统用户"},{"name":"nickname","type":"string","comment":"用户昵称"},{"name":"phone","type":"string","comment":"手机"},{"name":"email","type":"string","comment":"用户邮箱"},{"name":"avatar","type":"string","comment":"用户头像"},{"name":"signed","type":"string","comment":"个人签名"},{"name":"dashboard","type":"string","comment":"后台首页类型"},{"name":"status","type":"boolean","comment":"状态:1=正常,2=停用"},{"name":"login_ip","type":"string","comment":"最后登陆IP"},{"name":"login_time","type":"datetime","comment":"最后登陆时间"},{"name":"backend_setting","type":"json","comment":"后台设置数据"},{"name":"created_by","type":"bigint","comment":"创建者"},{"name":"updated_by","type":"bigint","comment":"更新者"},{"name":"created_at","type":"datetime","comment":null},{"name":"updated_at","type":"datetime","comment":null},{"name":"remark","type":"string","comment":"备注"}]}')]
    public function getTableInfo(GetTableInfoRequest $getTableInfoRequest): Result
    {
        $tableName = $getTableInfoRequest->all()['table_name'];
        $databaseConnection = $getTableInfoRequest->all()['database_connection'];
        return $this->success($this->service->getTableInfo($databaseConnection,$tableName));
    }

    #[Get(
        path: '/admin/plugin/code-generator/database/{databaseConnection}',
        operationId: 'PluginMineAdminCodeGeneratorGetDatabaseTableList',
        summary: '获取数据库表列表',
        tags: ['代码生成器'],
    )]
    #[ListResponse(instance:Result::class,example: '{"code":200,"message":"成功","data":[{"name":"user","comment":"用户信息表"},{"name":"migrations","comment":""},{"name":"menu","comment":"菜单信息表"},{"name":"role","comment":"角色信息表"},{"name":"role_belongs_menu","comment":""},{"name":"rules","comment":""},{"name":"user_belongs_role","comment":""},{"name":"user_login_log","comment":"登录日志表"},{"name":"user_operation_log","comment":"操作日志表"},{"name":"attachment","comment":"上传文件信息表"}]}')]
    public function getDatabaseTableList(string $databaseConnection = 'default'): Result
    {
        return $this->success($this->service->getDatabaseTableList($databaseConnection));
    }

    #[Post(
        path: '/admin/plugin/code-generator/save-table-setting',
        operationId: 'PluginMineAdminCodeGeneratorSaveTableSetting',
        summary: '保存表设置',
        tags: ['代码生成器'],
    )]
    public function saveTableSetting(SaveTableSettingRequest $request): Result
    {
        $this->service->create($request->validated());
        return $this->success();
    }

    #[Get(
        path: '/admin/plugin/code-generator/table-setting/{databaseConnection}/{tableName}',
        operationId: 'PluginMineAdminCodeGeneratorGetTableSetting',
        summary: '获取表设置',
        tags: ['代码生成器'],
    )]
    public function getTableSetting(string $databaseConnection, string $tableName): Result
    {
        return $this->success($this->service->getTableSetting($databaseConnection,$tableName));
    }

    #[Post(
        path: '/admin/plugin/code-generator/preview-table',
        operationId: 'PluginMineAdminCodeGeneratorPreviewTable',
        summary: '预览生成的代码',
        tags: ['代码生成器'],
    )]
    public function previewTable(PreviewAndGeneratorRequest $request): Result
    {
        return $this->success($this->service->getTablePreview($request->validated()));
    }

    #[Post(
        path: '/admin/plugin/code-generator/generator',
        operationId: 'PluginMineAdminCodeGeneratorGenerator',
        summary: '生成代码',
        tags: ['代码生成器'],

    )]
    public function generator(PreviewAndGeneratorRequest $request, ResponseInterface $response)
    {
        $type = GeneratorType::from((int)$request->all()['type']);
        if ($type === GeneratorType::ZIP){
             return $response->download($this->service->generatorZip($request->validated())->filename);
        }
        $this->service->generatorLocal($request->validated());
        return $this->success();
    }
}
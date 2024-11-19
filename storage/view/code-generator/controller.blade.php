@php use Hyperf\Stringable\Str;use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator ;use Plugin\MineAdmin\CodeGenerator\Model\Enums\SearchTypeEnum@endphp
@php /** @var CodeGenerator $codeGenerator */ @endphp
@php

    echo '<?php'.PHP_EOL;
    echo PHP_EOL;
    echo 'namespace App\\Http\\Admin\\Controller\\'.$codeGenerator->getPackageName() .';' . PHP_EOL;
    echo PHP_EOL;
    echo 'use App\Service\\'.$codeGenerator->getPackageName() .'\\'.$codeGenerator->getName().'Service as Service;';
    echo PHP_EOL;
    echo 'use App\Http\Admin\Request\\'.$codeGenerator->getPackageName() .'\\'.$codeGenerator->getName().'Request as Request;';
    echo PHP_EOL;
    echo 'use Hyperf\Swagger\Annotation as OA;';
    echo PHP_EOL;
    echo 'use App\Http\Admin\Controller\AbstractController;
use App\Http\Common\Middleware\AccessTokenMiddleware;
use App\Http\Common\Result;
use App\Http\CurrentUser;
use App\Http\Admin\Middleware\PermissionMiddleware;
use App\Http\Common\Middleware\OperationMiddleware;
use Mine\Access\Attribute\Permission;
use Hyperf\HttpServer\Annotation\Middleware;
use Mine\Swagger\Attributes\ResultResponse;
use Hyperf\Swagger\Annotation\Post;
use Hyperf\Swagger\Annotation\Put;
use Hyperf\Swagger\Annotation\Get;
use Hyperf\Swagger\Annotation\Delete;';
    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;
@endphp

#[OA\Tag('{{$codeGenerator->menu_name}}')]
#[OA\HyperfServer('http')]
#[Middleware(middleware: AccessTokenMiddleware::class, priority: 100)]
#[Middleware(middleware: PermissionMiddleware::class, priority: 99)]
#[Middleware(middleware: OperationMiddleware::class, priority: 98)]
class {{$codeGenerator->getName()}}Controller extends AbstractController
{
    public function __construct(
        private readonly Service $service,
        private readonly CurrentUser $currentUser
    ) {}

    #[Get(
        path: '/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}/list',
        operationId: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:list',
        summary: '{{$codeGenerator->menu_name}}列表',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['{{$codeGenerator->menu_name}}'],
    )]
    #[Permission(code: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:list')]
    public function pageList(): Result
    {
        return $this->success(
            $this->service->page(
                $this->getRequestData(),
                $this->getCurrentPage(),
                $this->getPageSize()
            )
        );
    }

    #[Post(
        path: '/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}',
        operationId: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:create',
        summary: '新增{{$codeGenerator->menu_name}}',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['{{$codeGenerator->menu_name}}'],
    )]
    #[Permission(code: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:create')]
    #[ResultResponse(instance: new Result())]
    public function create(Request $request): Result
    {
        $this->service->create(array_merge($request->validated(), [
            'created_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Put(
        path: '/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}/{id}',
        operationId: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:update',
        summary: '保存{{$codeGenerator->menu_name}}',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['{{$codeGenerator->menu_name}}'],
    )]
    #[Permission(code: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:update')]
    #[ResultResponse(instance: new Result())]
    public function save(int $id, Request $request): Result
    {
        $this->service->updateById($id, array_merge($request->validated(), [
            'updated_by' => $this->currentUser->id(),
        ]));
        return $this->success();
    }

    #[Delete(
        path: '/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}',
        operationId: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:delete',
        summary: '删除{{$codeGenerator->menu_name}}',
        security: [['Bearer' => [], 'ApiKey' => []]],
        tags: ['{{$codeGenerator->menu_name}}'],
    )]
    #[ResultResponse(instance: new Result())]
    #[Permission(code: '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:delete')]
    public function delete(): Result
    {
        $this->service->deleteById($this->getRequestData());
        return $this->success();
    }

}

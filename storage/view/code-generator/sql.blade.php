@php use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator ;use Plugin\MineAdmin\CodeGenerator\Model\Enums\SearchTypeEnum;use function Hyperf\Support\now@endphp
@php
    use Hyperf\Stringable\Str;
    /** @var CodeGenerator $codeGenerator */
    $time = now()->format('Y-m-d H:i:s');
@endphp

-- 页面

insert into `menu`
(`name`, `path`, `component`, `redirect`, `created_by`, `updated_by`, `remark`, `meta`, `parent_id`, `updated_at`, `created_at`)
values ('{{$codeGenerator->getName()}}', '/{{$codeGenerator->getPackageName()}}/{{$codeGenerator->getName()}}', '{{$codeGenerator->getPackageName()}}/views/{{$codeGenerator->getName()}}/Index', '', '0', '0', '', '{"title":"{{$codeGenerator->menu_name}}","i18n":"{{$codeGenerator->getPackageName()}}.{{$codeGenerator->getName()}}","icon":"","type":"M","hidden":false,"componentPath":"modules\/","componentSuffix":".vue","breadcrumbEnable":true,"copyright":true,"cache":true,"affix":false}', '{{$codeGenerator->menu_parent_id}}', '{{$time}}', '{{$time}}');

SET @LastInsertId := LAST_INSERT_ID();

-- 列表

insert into `menu` (`name`, `meta`, `parent_id`, `updated_at`, `created_at`) values (
    '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:list',
    '{"title":"{{$codeGenerator->menu_name}}列表","i18n":"{{$codeGenerator->getPackageName()}}.{{Str::snake($codeGenerator->getName())}}.list","icon":"","type":"B","hidden":false,"componentPath":"modules\/{{$codeGenerator->getPackageName()}}\/{{$codeGenerator->getName()}}\/","componentSuffix":".vue","breadcrumbEnable":true,"cache":true,"affix":false}',
    @LastInsertId,
    '{{$time}}',
    '{{$time}}'
);

-- 新增 {{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:create

insert into `menu` (`name`, `meta`, `parent_id`, `updated_at`, `created_at`) values (
    '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:create',
    '{"title":"{{$codeGenerator->menu_name}}新增","i18n":"{{$codeGenerator->getPackageName()}}.{{Str::snake($codeGenerator->getName())}}.create","icon":"","type":"B","hidden":true,"componentPath":"modules\/{{$codeGenerator->getPackageName()}}\/{{$codeGenerator->getName()}}\/","componentSuffix":".vue","breadcrumbEnable":true,"cache":true,"affix":false}',
    @LastInsertId,
    '{{$time}}',
    '{{$time}}'
);

-- 编辑 {{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:update

insert into `menu` (`name`, `meta`, `parent_id`, `updated_at`, `created_at`) values (
    '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:update',
    '{"title":"{{$codeGenerator->menu_name}}编辑","i18n":"{{$codeGenerator->getPackageName()}}.{{Str::snake($codeGenerator->getName())}}.update","icon":"","type":"B","hidden":true,"componentPath":"modules\/{{$codeGenerator->getPackageName()}}\/{{$codeGenerator->getName()}}\/","componentSuffix":".vue","breadcrumbEnable":true,"cache":true,"affix":false}',
    @LastInsertId,
    '{{$time}}',
    '{{$time}}'
);

-- 删除 {{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:delete

insert into `menu` (`name`, `meta`, `parent_id`, `updated_at`, `created_at`) values (
    '{{$codeGenerator->getPackageName()}}:{{Str::snake($codeGenerator->getName())}}:delete',
    '{"title":"{{$codeGenerator->menu_name}}删除","i18n":"{{$codeGenerator->getPackageName()}}.{{Str::snake($codeGenerator->getName())}}.delete","icon":"","type":"B","hidden":true,"componentPath":"modules\/{{$codeGenerator->getPackageName()}}\/{{$codeGenerator->getName()}}\/","componentSuffix":".vue","breadcrumbEnable":true,"cache":true,"affix":false}',
    @LastInsertId,
    '{{$time}}',
    '{{$time}}'
);






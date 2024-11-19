@php use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator ;use Plugin\MineAdmin\CodeGenerator\Model\Enums\SearchTypeEnum@endphp
@php /** @var CodeGenerator $codeGenerator */ @endphp
@php

    echo '<?php'.PHP_EOL;
    echo PHP_EOL;
    echo 'namespace App\\Service\\'.$codeGenerator->getPackageName() .';' . PHP_EOL;
    echo PHP_EOL;
    echo 'use App\Service\IService;';
    echo PHP_EOL;
    echo 'use App\\Repository\\'.$codeGenerator->getPackageName() .'\\'.$codeGenerator->getName().'Repository as Repository;';
    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;
@endphp

class {{$codeGenerator->getName()}}Service extends IService
{
    public function __construct(
        protected readonly Repository $repository
    ) {}
}

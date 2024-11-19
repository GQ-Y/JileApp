<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class RequestBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.request';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'app/Http/Admin/Request/'.$codeGenerator->getPackageName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return $codeGenerator->getName().'Request.php';
    }

}
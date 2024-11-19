<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class ServiceBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.service';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'app/Service/'.$codeGenerator->getPackageName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return $codeGenerator->getName().'Service.php';
    }

}
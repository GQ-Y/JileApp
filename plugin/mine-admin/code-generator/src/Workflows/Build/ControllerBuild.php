<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class ControllerBuild extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.controller';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'app/Http/Admin/Controller/'.$codeGenerator->getPackageName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return $codeGenerator->getName().'Controller.php';
    }
}
<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class ModelBuilder extends AbstractBuilder
{

    protected string $viewViewTemplate = 'code-generator.model';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'app/Model/'.$codeGenerator->getPackageName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return $codeGenerator->getName().'.php';
    }

}
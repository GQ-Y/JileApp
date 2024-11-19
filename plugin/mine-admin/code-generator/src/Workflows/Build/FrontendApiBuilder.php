<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class FrontendApiBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.frontend.api-ts';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'web/src/modules/'.$codeGenerator->getPackageName().'/api';
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return $codeGenerator->getName().'.ts';
    }

}
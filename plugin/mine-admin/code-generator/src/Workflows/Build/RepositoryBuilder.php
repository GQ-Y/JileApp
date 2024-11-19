<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class RepositoryBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.repository';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'app/Repository/'.$codeGenerator->getPackageName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return $codeGenerator->getName().'Repository.php';
    }

}
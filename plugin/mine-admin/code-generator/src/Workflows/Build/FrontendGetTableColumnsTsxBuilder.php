<?php

declare(strict_types=1);

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

class FrontendGetTableColumnsTsxBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.frontend.getTableColumns-tsx';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'web/src/modules/'.$codeGenerator->getPackageName().'/views/'.$codeGenerator->getName().'/components';
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return 'GetTableColumns.tsx';
    }
}

<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class FrontendGetSearchItemsTsxBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.frontend.getSearchItems-tsx';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'web/src/modules/'.$codeGenerator->getPackageName().'/views/'.$codeGenerator->getName().'/components';
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return 'GetSearchItems.tsx';
    }

}
<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class FrontendIndexVueBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.frontend.index-vue';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'web/src/modules/'.$codeGenerator->getPackageName().'/views/'.$codeGenerator->getName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return 'Index.vue';
    }
}
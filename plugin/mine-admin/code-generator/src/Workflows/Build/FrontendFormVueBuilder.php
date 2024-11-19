<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class FrontendFormVueBuilder extends AbstractBuilder
{
    protected string $viewViewTemplate = 'code-generator.frontend.form-vue';

    protected function formatRelativePath(CodeGenerator $codeGenerator): string
    {
        return 'web/src/modules/'.$codeGenerator->getPackageName().'/views/'.$codeGenerator->getName();
    }

    protected function formatFilename(CodeGenerator $codeGenerator): string
    {
        return 'Form.vue';
    }
}
<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;
use Symfony\Component\Finder\SplFileInfo;

interface WorkflowInterface
{
    /**
     * @return SplFileInfo[]
     */
    public function doRun(CodeGenerator $codeGenerator): array;
}
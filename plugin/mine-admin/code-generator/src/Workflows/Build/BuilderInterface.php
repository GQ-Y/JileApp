<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;
use Symfony\Component\Finder\SplFileInfo;

interface BuilderInterface
{
    /**
     * @param CodeGenerator $codeGenerator
     * @return SplFileInfo
     */
    public function build(CodeGenerator $codeGenerator): SplFileInfo;
}
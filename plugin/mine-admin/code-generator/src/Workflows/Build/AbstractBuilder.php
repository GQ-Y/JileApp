<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Build;

use Hyperf\View\RenderInterface;
use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;
use Symfony\Component\Finder\SplFileInfo;

abstract class AbstractBuilder implements BuilderInterface
{
    public function __construct(
        protected RenderInterface $render
    ){}

    protected string $viewViewTemplate = '';

    protected function buildStage(CodeGenerator $codeGenerator): string
    {
        return $this->render->getContents($this->viewViewTemplate, ['codeGenerator' => $codeGenerator]);
    }

    abstract protected function formatRelativePath(CodeGenerator $codeGenerator): string;

    abstract protected function formatFilename(CodeGenerator $codeGenerator): string;

    public function build(CodeGenerator $codeGenerator): SplFileInfo
    {
        $fileContent = $this->buildStage($codeGenerator);
        $temp = tempnam(sys_get_temp_dir(), 'code-generator');
        file_put_contents($temp, $fileContent);
        return new SplFileInfo($temp, $this->formatRelativePath($codeGenerator), $this->formatFilename($codeGenerator));
    }
}
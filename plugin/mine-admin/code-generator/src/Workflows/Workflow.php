<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows;

use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\BuilderInterface;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\ControllerBuild;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\FrontendApiBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\FrontendFormVueBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\FrontendGetFormItemsTsxBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\FrontendGetSearchItemsTsxBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\FrontendGetTableColumnsTsxBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\FrontendIndexVueBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\ModelBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\RepositoryBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\RequestBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\ServiceBuilder;
use Plugin\MineAdmin\CodeGenerator\Workflows\Strategy\AbstractStrategy;

final class Workflow implements WorkflowInterface
{
    public function __construct(
        private readonly AbstractStrategy $strategy
    ){}

    /**
     * @inheritDoc
     */
    public function doRun(CodeGenerator $codeGenerator): array
    {
        $files = [];

        foreach ($this->strategy->list() as $builder){
            $files[] = $builder->build($codeGenerator);
        }

        return $files;
    }
}
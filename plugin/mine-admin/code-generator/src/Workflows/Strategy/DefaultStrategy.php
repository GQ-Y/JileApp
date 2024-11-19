<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Strategy;

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
use Plugin\MineAdmin\CodeGenerator\Workflows\Build\SqlBuild;
use Psr\Container\ContainerInterface;

class DefaultStrategy extends AbstractStrategy
{
    private array $classes = [
        SqlBuild::class,
        ModelBuilder::class,
        RepositoryBuilder::class,
        RequestBuilder::class,
        ServiceBuilder::class,
        ControllerBuild::class,
        FrontendApiBuilder::class,
        FrontendGetSearchItemsTsxBuilder::class,
        FrontendGetFormItemsTsxBuilder::class,
        FrontendGetTableColumnsTsxBuilder::class,
        FrontendFormVueBuilder::class,
        FrontendIndexVueBuilder::class
    ];
    public function __construct(
        ContainerInterface $container
    )
    {
        foreach ($this->classes as $buildClass){
            $this->builders[] = $container->get($buildClass);
        }
    }
}
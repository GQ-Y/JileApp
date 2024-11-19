<?php

namespace Plugin\MineAdmin\CodeGenerator\Workflows\Strategy;

use Plugin\MineAdmin\CodeGenerator\Workflows\Build\AbstractBuilder;

abstract class AbstractStrategy
{
    /**
     * @var AbstractBuilder[] $builders
     */
    protected array $builders = [];

    public function list(): array
    {
        return $this->builders;
    }
}
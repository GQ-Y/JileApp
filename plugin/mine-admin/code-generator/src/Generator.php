<?php

namespace Plugin\MineAdmin\CodeGenerator;



use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class Generator
{
    public function __construct(
        private CodeGenerator $codeGenerator,

    ){}
}
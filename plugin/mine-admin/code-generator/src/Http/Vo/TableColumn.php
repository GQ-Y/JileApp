<?php

namespace Plugin\MineAdmin\CodeGenerator\Http\Vo;

final class TableColumn
{
    public function __construct(
        public string $name,
        public string $type,
        public ?string $comment,
    ){}
}